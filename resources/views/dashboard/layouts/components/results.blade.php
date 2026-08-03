<div class="result">
    <div class="row">
        <div class="col-12">

            <!-- Success Alert  -->
            @if (session()->has('success'))
                <div class="mt-3 alert alert-box-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <!-- Error Alert -->
            @if (session()->has('error'))
                <div class="mt-3 alert alert-box-error alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-xmark"></i> {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <!-- Warning Alert -->
            @if (session()->has('warning'))
                <div class="mt-3 alert alert-box-warning alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i> {{ session()->get('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <!-- Info Alert -->
            @if (session()->has('info'))
                <div class="mt-3 alert alert-box-info alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-info"></i> {{ session()->get('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        </div>
    </div>

  
</div><!-- Result Box -->
