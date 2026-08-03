  <form class="ajax-post" action="{{ route('create-admin') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-row">

          <div class="col-6">
              <x-form-group :properties="[
                  'input' => [
                      'name' => 'f_name',
                      'options' => ['required'],
                  ],
                  'label' => [
                      'text' => 'الاسم الأول',
                      'options' => ['class' => 'required'],
                  ],
              ]" /><!-- f_name -->
          </div>

          <div class="col-6">
              <x-form-group :properties="[
                  'input' => [
                      'name' => 'l_name',
                      'options' => ['required'],
                  ],
                  'label' => [
                      'text' => 'الاسم الاخير',
                      'options' => ['class' => 'required'],
                  ],
              ]" /><!-- l_name -->
          </div>

          <div class="col-12">
              <x-form-group :properties="[
                  'input' => [
                      'name' => 'email',
                      'type' => 'email',
                      'options' => ['required'],
                  ],
                  'label' => [
                      'text' => 'البريد الإلكتروني',
                      'options' => ['class' => 'required'],
                  ],
              ]" /><!-- email -->
          </div>


          <div class="col-sm-9 col-7">
              <div class=" input-normal-style">
                  <x-form-group :properties="[
                      'input' => [
                          'name' => 'password',
                          'options' => ['required', 'class' => 'accept-random'],
                      ],
                      'label' => [
                          'text' => 'كلمة المرور',
                          'options' => ['class' => 'required'],
                      ],
                  ]" /><!-- password -->
              </div>
          </div>


          <div class="col-sm-3 col-5 mt-2">
              <button type="button" class="generate-random btn-block btn btn-soft-main mt-4">
                  عشوائية
              </button>
          </div>

          <div class="col-12">
              <div class="input-normal-style">
                  <label class="font-weight-600">نوع المشرف <span class="text-danger">*</span></label>
                  <div class=" d-flex">

                      <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="adminTypeSales" name="type"
                              value="sales" checked>
                          <label class="custom-control-label cursor-pointer" for="adminTypeSales">
                              مسؤول مبيعات
                          </label>
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="adminTypeGeneral" name="type"
                              value="admin">
                          <label class="custom-control-label cursor-pointer" for="adminTypeGeneral">
                              مشرف عام
                          </label>
                      </div>



                  </div>
              </div>
          </div>

          <div class="col-12" id="rolesSection" style="display: none;">
              <div class="input-normal-style mt-2">
                  <label class="font-weight-600">الأدوار</label>
                  <div class="form-row">
                      @foreach ($roles as $role)
                          @if (!in_array($role->name, ['sales']))
                              <div class="col-md-6 col-12">
                                  <div class="form-group mb-0">
                                      <label class="d-inline-block cursor-pointer">
                                          <input class="d-inline-block role-checkbox" type="checkbox" name="roles[]"
                                              value="{{ $role->name }}">
                                          {{ Str::headLine(Str::limit($role->name, 30)) }}
                                      </label>
                                  </div>
                              </div>
                          @endif
                      @endforeach
                  </div>
              </div>
          </div>



      </div> <!-- row -->
      <hr>
      <button type="submit" class="btn btn-main px-4 mt-2">حفظ</button>
  </form>
