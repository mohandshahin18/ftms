@extends('admin.master')

@section('title', __('admin.Settings'))
@section('sub-title', __('admin.Settings'))

@section('content')



    <div class="col-lg-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">{{ __('admin.Settings') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">{{ __('admin.Team Members') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-team-tab" data-toggle="pill" href="#custom-tabs-four-team" role="tab" aria-controls="custom-tabs-four-team" aria-selected="false">{{ __('admin.Add new member') }}</a>
              </li>


            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
              <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                    <div class="card-body">
                        <form action="{{ route('admin.settings_store') }}" class="edit-settings" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="row">

                            {{-- footer text  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Footer Text') }}</label>
                                    <input type="text" class="form-control @error('footer_text') is-invalid @enderror"
                                        name="footer_text" placeholder=" {{ __('admin.Footer Text') }}" value="{{ old('footer_text',settings()->get('footer_text')) }}">
                                    @error('footer_text')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- Email Technical support  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Email Technical support') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder=" {{ __('admin.Email Technical support') }}" value="{{ old('email',settings()->get('email')) }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- copy right  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Copy Right') }}</label>
                                    <input type="text" class="form-control @error('copy_right') is-invalid @enderror"
                                        name="copy_right" placeholder="{{ __('admin.Copy Right') }}" value="{{ old('copy_right',settings()->get('copy_right')) }}">
                                    @error('copy_right')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- distributed_by   --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Distributed by') }}</label>
                                    <input type="text" class="form-control @error('distributed_by') is-invalid @enderror"
                                        name="distributed_by" placeholder=" {{ __('admin.Distributed by') }}"
                                        value="{{ old('distributed_by',settings()->get('distributed_by')) }}">
                                        @error('distributed_by')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                        @enderror
                                </div>
                            </div>


                            {{-- Logo  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Logo Website & Control Panle') }}</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        name="logo" >
                                        <img width="70"  class="bg-dark" src="{{ asset(settings()->get('logo')) }}" alt="">

                                    @error('logo')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Logo  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Dark Logo') }}</label>
                                    <input type="file" class="form-control @error('darkLogo') is-invalid @enderror"
                                        name="darkLogo">
                                        <img width="70"  class="bg-dark" src="{{ asset(settings()->get('darkLogo')) }}" alt="">

                                    @error('darkLogo')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="card-footer d-flex justify-content-end">

                                <button type="button" class="btn btn-primary btn-edit-settings">
                                    <i class="fas fa-pen"></i> {{ __('admin.Update') }} </button>

                        </div>
                    </form>

                    </div>
                    <!-- /.card-body -->



            </div>
              <div class="tab-pane fade" id="custom-tabs-four-team" role="tabpanel" aria-labelledby="custom-tabs-four-team-tab">
                <form action="{{ route('admin.settings_website') }}" method="POST" class="add-memeber" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                         {{-- footer text  --}}
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Name') }}</label>
                            <input type="text" class="form-control members @error('name') is-invalid @enderror"
                                name="name" id="name" placeholder=" {{ __('admin.Name') }}" value="{{ old('name') }}">
                            @error('name')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    {{-- Email Technical support  --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Specialization') }}</label>
                            <input type="text" class="form-control members @error('specialization') is-invalid @enderror"
                                name="specialization" id="specialization" placeholder=" {{ __('admin.Specialization') }}" value="{{ old('specialization') }}">
                            @error('specialization')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                      {{-- Email Technical support  --}}
                      <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Facebook Link') }}</label>
                            <input type="text" class="form-control members @error('facebook') is-invalid @enderror"
                                name="facebook" id="facebook" placeholder=" {{ __('admin.Facebook Link') }}" value="{{ old('facebook') }}">
                            @error('facebook')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                      {{-- Email Technical support  --}}
                      <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.GitHub Link') }}</label>
                            <input type="text" class="form-control members @error('github') is-invalid @enderror"
                                name="github" id="github" placeholder=" {{ __('admin.GitHub Link') }}" value="{{ old('github') }}">
                            @error('github')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                     {{-- Email Technical support  --}}
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Linkedin Link') }}</label>
                            <input type="text" class="form-control members @error('linkedin') is-invalid @enderror"
                                name="linkedin" id="linkedin" placeholder=" {{ __('admin.Linkedin Link') }}" value="{{ old('linkedin') }}">
                            @error('linkedin')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Email Technical support  --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Image') }}</label>
                            <input type="file" class="form-control members @error('image') is-invalid @enderror"
                                name="image" id="image">
                            @error('image')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">

                            <button type="submit" class="btn btn-primary btn-add">
                                <i class="fas fa-plus"></i> {{ __('admin.Add') }} </button>

                    </div>
                </form>
            </div>
              <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                <div class="row">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped  table-hover ">
                              <thead>
                                  <tr style="background-color: #1e272f; color: #fff;">
                                      <th>#</th>
                                      <th>{{ __('admin.Name') }}</th>
                                      <th>{{ __('admin.Specialization') }}</th>
                                      <th>{{ __('admin.Image') }}</th>
                                      <th>{{ __('admin.Actions') }}</th>
                                  </tr>
                              </thead>
                              <tbody>
                                      @forelse ($team_members as $member)
                                      <tr id="row_{{ $member->id }}">
                                        <td>{{ $member->id }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->specialization }}</td>
                                        <td><img src="{{ asset($member->image) }}" width="100" alt=""></td>
                                        <td>
                                            <div style="display: flex; gap: 5px" class="">
                                              <a title="{{ __('admin.Edit') }}" href="" class="btn btn-primary btn-sm btn-edit"
                                              data-toggle="modal"  data-target="#editMember" data-name="{{ $member->name }}"
                                              data-specialization="{{ $member->specialization }}" data-facebook="{{ $member->facebook }}"
                                              data-linkedin="{{ $member->linkedin }}" data-image="{{ $member->image }}" data-github="{{ $member->github }}"
                                              data-url="{{ route('admin.editMember', $member->id) }}"> <i class="fas fa-edit"></i> </a>

                                              <form class="delete_form" method="POST" action="{{ route('admin.deleteMember',$member->id) }}">
                                                @csrf
                                                @method('delete')
                                                <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-trash"></i> </button>
                                              </form>
                                            </div>

                                        </td>
                                    </tr>
                                      @empty

                                      @endforelse

                              </tbody>
                          </table>
                      </div>
                </div>
            </div>

            </div>
          </div>
          <!-- /.card -->
        </div>


      </div>


          <!-- Modal Edit Category -->
    <div class="modal fade" id="editMember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">{{ __('admin.Edit Program') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_form" action="" method="Post">
                    <div class="modal-body">


                        @csrf
                        @method('put')
                        <div class="row">

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.Name') }}</label>
                                <input type="text" class="form-control" name="name" placeholder="{{ __('admin.Name') }}">
                            </div>
                            {{-- end name --}}

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.Specialization') }}</label>
                                <input type="text" class="form-control" name="specialization" placeholder="{{ __('admin.Specialization') }}">
                            </div>
                            {{-- end name --}}

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.Facebook Link') }}</label>
                                <input type="text" class="form-control" name="facebook" placeholder="{{ __('admin.Facebook Link') }}">
                            </div>
                            {{-- end name --}}

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.GitHub Link') }}</label>
                                <input type="text" class="form-control" name="github" placeholder="{{ __('admin.GitHub Link') }}">
                            </div>
                            {{-- end name --}}

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.Linkedin Link') }}</label>
                                <input type="text" class="form-control" name="linkedin" placeholder="{{ __('admin.Linkedin Link') }}">
                            </div>
                            {{-- end name --}}

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.Image') }}</label>
                                <input type="file" class="form-control" name="image" >
                                <img src="" width="100" id="image-member" alt="">
                            </div>
                            {{-- end name --}}

                        </div>

                        <div class="alert alert-danger d-none">
                            <ul>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save Edit') }}</button>
                    </div>

                </form>


            </div>
        </div>
    </div>

@stop


@section('scripts')

<script>


    $('input[type=file]').on('change', function(e) {
        // console.log(e.target);
        if (e.target.files && e.target.files[0]) {
            let inp = $(this)
            var reader = new FileReader();
            reader.onload = function (e) {
                // console.log(inp);
                inp.next('img').attr('src', e.target.result).width(70);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    })

</script>


<script>
    let btn_add = $('.btn-add');
    let form = $(".add-memeber")[0];

form.onsubmit = (e)=> {
    e.preventDefault();
}

btn_add.on("click", function() {

let formData = new FormData(form);
let url = form.getAttribute("action");
    $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.invalid-feedback').remove();
                    $('input').removeClass('is-invalid');
                    $('.members').val('');

                    $("tbody").prepend(
                        `<tr id="row_${data.id}">

                        <td >${data.id}</td>
                                        <td id="name">${data.name}</td>
                                        <td>${data.specialization}</td>

                                        <td id="image" ><img src="${host}/${data.image}" width="100" alt=""></td>

                                        <td>
                                            <div style="display: flex; gap: 5px" class="">
                                              <a title="{{ __('admin.Edit') }}" href="" class="btn btn-primary btn-sm btn-edit"
                                              data-toggle="modal"  data-target="#editMember" data-name="${data.name}"
                                              data-specialization="${data.specialization}" data-facebook="${data.facebook}"
                                              data-linkedin="${data.linkedin}" data-image="${data.image}" data-github="${data.github}"
                                              data-url="admin/settings/edit/member/${data.id}"
                                              > <i class="fas fa-edit"></i> </a>

                                              <form class="delete_form" method="POST" action="settings/delete/member/${data.id}">
                                                @csrf
                                                @method('delete')
                                                <button title="{{ __('admin.Move Delete') }}" class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-trash"></i> </button>
                                              </form>
                                            </div>

                    </td>`
                    );

                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'success',
                    title: '{{ __('admin.Member has been added successfully') }}'
                    })
                } ,
                error: function(data) {
                    $('.invalid-feedback').remove();
                    $.each(data.responseJSON.errors, function (field, error) {

                        $("input[id='"+field+"']").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                    });
                } ,
            })

});


        $(document).ready(function() {
    // get old data from edit button
    $('tbody').on('click','.btn-edit', function() {
        let name = $(this).data('name');
        let specialization = $(this).data('specialization');
        let facebook = $(this).data('facebook');
        let github = $(this).data('github');
        let linkedin = $(this).data('linkedin');
        let image = $(this).data('image');

        let url = $(this).data('url');

        $('#editMember form').attr('action', url);
        $('#editMember input[name=name]').val(name);
        $('#editMember input[name=specialization]').val(specialization);
        $('#editMember input[name=facebook]').val(facebook);
        $('#editMember input[name=github]').val(github);
        $('#editMember input[name=linkedin]').val(linkedin);
        $('#image-member').attr('src',host+'/'+image);


        $('#editMember .alert ').addClass('d-none');
        $('#editMember .alert ul').html('');

    });

    // send data using ajax
    $('#edit_form').on('submit', function(e) {

        let formData = new FormData(this);

        e.preventDefault();


        // send ajax request
        $.ajax({

            type: 'post',
            url: $('#editMember form').attr('action'),
            data: formData,
            processData : false ,
            cach : false ,
            contentType : false ,
            success: function(res) {

                $('#row_' + res.id + " td:nth-child(2)").text(res.name);
                $('#row_' + res.id + " td:nth-child(3)").text(res.specialization);
                $('#row_' + res.id + " td:nth-child(4) img").attr('src',host+'/'+res.image);
                console.log(host+'/'+res.image);


                $('#editMember').modal('hide');

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: '{{ __('admin.Member has been updated successfully') }}'
                });
                $('#editMember').modal('hide');
            },
            error: function(err) {
                $('#editMember .alert ul').html('');
                $('#editMember .alert ').removeClass('d-none');
                for (const key in err.responseJSON.errors) {
                    let li = '<li>' + err.responseJSON.errors[key] + '</li>';
                    $('#editMember .alert ul').append(li);
                }
            }

        });

    });
        })


    let btn_edit = $('.btn-edit-settings');
    let form_EditSettings = $(".edit-settings")[0];

    form_EditSettings.onsubmit = (e)=> {
            e.preventDefault();
        }

btn_edit.on("click", function() {

let formData = new FormData(form_EditSettings);
let url = form_EditSettings.getAttribute("action");
    $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.invalid-feedback').remove();
                    $('input').removeClass('is-invalid');

                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })
                    $('#logo').attr('src',host+'/'+data);
                    console.log(data);
                    Toast.fire({
                    icon: 'success',
                    title: '{{ __('admin.Settings Updated succssfully') }}'
                    })
                } ,
                error: function(data) {
                    $('.invalid-feedback').remove();
                    $.each(data.responseJSON.errors, function (field, error) {

                        $("input[name='" + field + "']").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                    });
                } ,
            })

});


</script>

@stop
