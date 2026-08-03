<?php

namespace App\Http\Controllers\Dashboard\MailBox;

use Illuminate\Http\Request;
use App\Models\Dashboard\Emails;
use App\Models\Dashboard\Mailbox;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\MailReply;
use App\Models\Ips;

class MailboxController extends Controller
{

    /**
     * Global
     */
    public function navTabs()
    {
        return [
            [
                'name' => dbTrans('mailbox.inbox'),
                'icon' => '<i class="fa-solid fa-inbox"></i>',
            ],
            [
                'name' => dbTrans('mailbox.sent'),
                'icon' => '<i class="fa-regular fa-envelope"></i>',
            ],
            [
                'name' => dbTrans('mailbox.trash'),
                'icon' => '<i class="fa-solid fa-trash-can"></i>',
            ]
        ];
    }


    // Table Name
    private function table()
    {
        $model =  new Mailbox;
        return $model->table;
    }

    // Get Mail Row
    public function getRow($id, $columns = ['*'])
    {
        return  DB::table($this->table())->where('id', $id)->first($columns);
    }

    // Change Read Status
    public function changeStatus($id)
    {
        return  DB::table($this->table())->where('id', $id)->update(['read' => "1"]);
    }


    // All Mails
    public function index()
    {

        $countReadMails = Mailbox::where('read', '1')->count();
        $countUnReadMails = Mailbox::where('read', '0')->count();



        $mails = Mailbox::orderByDesc('id')->select(['name', 'subject', 'created_at', 'read', 'id']);

        return view('dashboard.mailbox.index', [
            
            'tabs' => $this->navTabs(),
            'countMails' => $mails->count(),

            'mails' => $mails->paginate(12),
            'countReadMails' => $countReadMails,
            'countUnReadMails' => $countUnReadMails,

        ]);
    }



    // Load Last Mails
    public function loadLatest()
    {
        $mails = DB::table($this->table())->orderByDesc('id')->select(['name', 'subject', 'created_at', 'read', 'id'])->limit(15)->get();
        return view('dashboard.mailbox.load-latest', compact('mails'));
    }


    // Read Mail
    public function show($id)
    {

        // Change Status
        $this->changeStatus($id);

        // Get Mail For Read
        $row = Mailbox::with('get', 'ip')->where('id', $id)->first();

        if (empty($row)) {
            return redirect(adminUrl('mail'));
        }

        // Get All Messages From This Email
        $listOfMessages = Emails::with(['mails' => function ($q) {
            $q->select('name', 'from', 'id', 'read', 'subject')->orderByDesc('id');
        }])->where('id', $row->from)->first(['id', 'email']);


        // Get Replays
        $replies = MailReply::with('admin')->where('mail', $id)->orderByDesc('id')->get();


        return view('dashboard.mailbox.read', [
            'tabs' => $this->navTabs(),
            'row' => $row,
            'replies' => $replies,
            'listOfMessages' => $listOfMessages
        ]);
    }



    public function destroy(Mailbox $mailbox)
    {
        //
    }



    /*
    |
    | Multi Actions
    |
    */
    private function moveToTrash($items, $table)
    {
        if (!empty($items)) {
            // First Check IF This Article Exist
            foreach ($items as $id) {

                // Get Row And Check IF IN Database
                DB::table($table)->delete($id);
            }
            request()->session()->flash('success', 'تم الحذف بنجاح');
        } else {
            request()->session()->flash('warning', 'لا توجد رسائل مختارة حتى الآن!');
        }
    }

    private function readAll($items, $table)
    {
        if (!empty($items)) {
            // First Check IF This Article Exist
            foreach ($items as $id) {

                // Get Row And Check IF IN Database
                DB::table($table)->where('id', $id)->update(['read' => "1"]);
            }
            request()->session()->flash('success', 'تم تمييز الرسائل كمقروء بنجاح');
        } else {
            request()->session()->flash('warning', 'لا توجد رسائل مختارة حتى الآن!');
        }
    }


    private function blockIps($items)
    {
        if (!empty($items)) {
            // First Check IF This Article Exist
            foreach ($items as $id) {

                $row =  Ips::where('mail_id', $id)->first();

                if ($row != null) {
                    $status = '0';
                    if ($row->status == '0') {
                        $status = '1';
                    }

                    // Get Row And Check IF IN Database
                    $row->update(['status' => $status]);
                }
            }
            request()->session()->flash('success', 'تم حظر عنوان Ip لهذا البريد الإلكتروني');
        } else {
            request()->session()->flash('warning', 'No Selected Rows Yet !');
        }
    }


    // Implement Action
    public function multiActions(Request $request, Mailbox $mailbox)
    {


        // Table Name
        $table = $mailbox->table;

        // Request Inputs
        $action = $request->action;
        $items = $request->id;

        if ($action == 'trash') {
            $this->moveToTrash($items, $table);
        } elseif ($action == 'read') {
            $this->readAll($items, $table);
        } elseif ($action == 'block') {
            $this->blockIps($items);
        } else {
            $request->session()->flash('error', 'Not HAVE Action');
        }

        return back();
    }
}
