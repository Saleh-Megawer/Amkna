<?php
namespace App\Http\Controllers\Client\OwnerAssociation;

use App\Http\Controllers\Controller;
use App\Models\OwnerAssociation\OwnerAssociationPoll;
use App\Models\OwnerAssociation\OwnerAssociationPollVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerAssociationPollController extends Controller
{
    /**
     * عرض كل التصويتات المتاحة للعميل
     */
    public function index()
    {
        $pageTitle = __('client.polls.page_title');
        $client    = client();

        // جلب الاتحادات التي ينتمي لها العميل بشكل آمن
        $ownerAssociationIds = $client->ownerAssociationUnits()
            ->pluck('owner_association_id')
            ->unique()
            ->toArray();

        // إذا لم يكن العميل ينتمي لأي اتحاد
        if (empty($ownerAssociationIds)) {
            $polls = collect();
        } else {
            // جلب التصويتات المتاحة فقط للاتحادات التي ينتمي لها
            $polls = OwnerAssociationPoll::whereIn('owner_association_id', $ownerAssociationIds)
                ->with(['ownerAssociation:id,uuid,name'])
                ->withCount('votes')
                ->latest()
                ->paginate(10);

            // إضافة حالة التصويت لكل استطلاع
            $polls->getCollection()->transform(function ($poll) use ($client) {
                $poll->has_voted = $poll->hasVoted($client->id);
                return $poll;
            });
        }

        return view('clients.owner-associations.polls.index', compact('pageTitle', 'polls'));
    }

    public function show(string $uuid)
    {
        $client = client();

        $poll = OwnerAssociationPoll::with('ownerAssociation')
            ->where('uuid', $uuid)
            ->firstOrFail();

        // ✅ التحقق من صلاحية العميل للوصول لهذا التصويت
        $clientUnit = $client->ownerAssociationUnits()
            ->where('owner_association_id', $poll->owner_association_id)
            ->first();

        if (! $clientUnit) {
            abort(403, __('client.polls.not_authorized'));
        }

        // التحقق إذا صوت قبل كده وجلب الصوت الخاص به فقط
        $clientVote = OwnerAssociationPollVote::where('poll_id', $poll->id)
            ->where('client_id', $client->id) // ✅ التأكد من أنه صوت العميل الحالي
            ->first();

        $hasVoted = ! is_null($clientVote);

        // حساب الأصوات الكلية (من كل العملاء)
        $yesVotes = OwnerAssociationPollVote::where('poll_id', $poll->id)
            ->where('vote', 'yes')
            ->count();

        $noVotes = OwnerAssociationPollVote::where('poll_id', $poll->id)
            ->where('vote', 'no')
            ->count();

        $totalVotes = $yesVotes + $noVotes;

        // حساب النسب المئوية
        $yesPercentage = $totalVotes > 0 ? round(($yesVotes / $totalVotes) * 100, 1) : 0;
        $noPercentage  = $totalVotes > 0 ? round(($noVotes / $totalVotes) * 100, 1) : 0;

        $pageTitle = __('client.polls.poll_details'); // أو أي نص تاني

        return view('clients.owner-associations.polls.show', compact(
            'poll',
            'pageTitle',
            'hasVoted',
            'clientVote',
            'yesVotes',
            'noVotes',
            'totalVotes',
            'yesPercentage',
            'noPercentage'
        ));
    }

    public function vote(Request $request, string $uuid)
    {
        $client = client();

        $poll = OwnerAssociationPoll::where('uuid', $uuid)
            ->lockForUpdate() // ✅ قفل السطر لمنع race condition
            ->firstOrFail();

        // ✅ التحقق من صلاحية العميل للتصويت في هذا الاستطلاع
        $clientUnit = $client->ownerAssociationUnits()
            ->where('owner_association_id', $poll->owner_association_id)
            ->first();

        if (! $clientUnit) {
            return back()->with('error', __('client.polls.not_authorized'));
        }

        // التحقق أن التصويت مازال مفتوح
        if (! $poll->is_active) {
            return back()->with('error', __('client.polls.closed_error'));
        }

        // ✅ التحقق إذا صوت هذا العميل بالتحديد قبل كده
        $hasVoted = OwnerAssociationPollVote::where('poll_id', $poll->id)
            ->where('client_id', $client->id)
            ->exists();

        if ($hasVoted) {
            return back()->with('error', __('client.polls.already_voted'));
        }

        // Validation
        $validated = $request->validate([
            'vote'  => 'required|in:yes,no',
            'notes' => 'nullable|string|max:1000',
        ]);

        // ✅ حفظ الصوت داخل transaction لضمان سلامة البيانات
        DB::transaction(function () use ($poll, $client, $validated) {
            // التحقق مرة أخرى داخل الـ transaction (Double-check)
            $exists = OwnerAssociationPollVote::where('poll_id', $poll->id)
                ->where('client_id', $client->id)
                ->exists();

            if ($exists) {
                throw new \Exception(__('client.polls.already_voted'));
            }

            // حفظ الصوت
            OwnerAssociationPollVote::create([
                'poll_id'   => $poll->id,
                'client_id' => $client->id, // ✅ العميل الحالي فقط
                'vote'      => $validated['vote'],
                'notes'     => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('main.clients.owner-association.polls.show', $poll->uuid)
            ->with('success', __('client.polls.vote_success'));
    }
}
