@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
@endpush
@section('content')
<!--  -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h3 class="card-title d-inline-block">All user lists</h3>
          <div class="text-right d-inline-block">
            <button class="btn btn-sm btn-dark float-right  ml-2" onclick="addModel()"><i class="fa fa-plus" aria-hidden="true"></i> Add User</button>
          </div>
        </div>
        <div class="card-body">
          <table id="data_table_main" class="table table-bordered table-striped w-100">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  -->

@include('users.modal')
@endsection
@push('script')
<script>
  function addModel() {
    var $alertas = $('#users_form');
    $alertas.validate().resetForm();
    $alertas.find('.error').removeClass('error');
    $('#users_form')[0].reset();
    $("#modal-add-update").modal('show');
    $("#id").val(0);
    $("#modal-add-update-title").text('Add User');
    $("#preview_div").hide();
    $('#project_btn').html('Add <span style="display: none" id="loader"><i class="fa fa-spinner fa-spin"></i></span>');
  }
  $(document).ready(function() {

    // View user
    $(document).on('click', '.module_view_record', function() {
      const id = $(this).parent().data("id");
      const url = $(this).parent().data("url");
      $("#view_user_modal").modal('show');
      $("#view_user_modal .loader").addClass('d-flex');
      $.ajax({
        type: 'GET',
        data: {
          id: id,
          _method: 'SHOW'
        },
        url: `${url}/${id}`,
        headers: {
          'X-CSRF-TOKEN': csrf_token
        },
        success: function(response) {
          $("#view_user_modal .loader").removeClass('d-flex');
          if (response.status) {
            $.each(response.data, function(key, value) {
              $(`#info_${key}`).text(value);
              if (key == 'image') {
                $(`#info_${key}`).attr("src", value);
              }
            });
          } else {
            toastr.error(response.message);
          }
        },
        error: function() {
          $("#view_user_modal .loader").removeClass('d-flex');
          toastr.error('Please Reload Page.');
        }
      });

    });

    // delete user
    $(document).on('click', '.module_delete_record', function() {
      const id = $(this).parent().data("id");
      const url = $(this).parent().data("url");
      deleteRecordModule(id, `${url}/${id}`);
    });

    // edit user
    $(document).on('click', '.module_edit_record', function() {
      const id = $(this).parent().data("id");
      const url = $(this).parent().data("url");
      $("#modal-add-update").modal('show');
      $('#image_preview').attr("");
      $.ajax({
        type: 'GET',
        data: {
          id: id,
          _method: 'SHOW'
        },
        url: `${url}/${id}`,
        headers: {
          'X-CSRF-TOKEN': csrf_token
        },
        success: function(response) {
          if (response.status) {
            $.each(response.data, function(key, value) {
              if (key == 'image') {
                $('#image_preview').attr("src", value);
              } else {
                $(`#${key}`).val(value);
              }
            });
          } else {
            toastr.error(response.message);
          }
        },
        error: function() {
          toastr.error('Please Reload Page.');
        }
      });
      $('#users_form_btn').html('Update <span style="display: none" id="users_form_loader"><i class="fa fa-spinner fa-spin"></i></span>');
    });


    $("#users_form").validate({
      rules: {
        first_name: {
          required: true,
          lettersonly: true
        },
        last_name: {
          required: true,
          lettersonly: true
        },
        name: {
          required: true,
        },
        email: {
          required: true,
          email: true,
        },
        image: {
          accept: "image/jpg,image/jpeg,image/png"
        },
        password: {
          minlength: 6,
        },
        password_confirmation: {
          equalTo: "#password"
        },
      },
      messages: {
        first_name: {
          required: "Please enter firstname",
          lettersonly: "Please enter valid firstname"
        },
        last_name: {
          required: "Please enter lastname",
          lettersonly: "Please enter valid lastname"
        },
        email: {
          required: "Please enter email",
          email: "Please enter valid email",
        },
        name: {
          required: "Please enter name",
        },
        image: {
          accept: 'Only allow image!'
        },
        password: {
          minlength: "Please enter password atleast 6 character!"
        },
        password_confirmation: {
          equalTo: "password and confirm password not match"
        },

      },
      submitHandler: function(form, e) {
        e.preventDefault();
        console.log(form)
        const formbtn = $('#users_form_btn');
        const formloader = $('#users_form_loader');
        console.log(formloader)
        $.ajax({
          url: form.action,
          type: "POST",
          data: new FormData(form),
          dataType: 'json',
          processData: false,
          contentType: false,
          headers: {
            'X-CSRF-TOKEN': csrf_token
          },
          beforeSend: function() {
            formloader.show();
            formbtn.prop('disabled', true);
          },
          success: function(result) {
            formloader.hide();
            formbtn.prop('disabled', false);
            if (result.status) {
              $('#users_form')[0].reset();
              $("#modal-add-update").modal('hide');
              $('#data_table_main').DataTable().ajax.reload();
              toastr.success(result.message);
            } else {
              toastr.error(result.message);
            }
          },
          error: function() {
            toastr.error('Please Reload Page.');
            formloader.hide();
            formbtn.prop('disabled', false);
          }
        });
        return false;
      }
    });
    // Get user data
    var table = $('#data_table_main').DataTable({
      processing: true,
      serverSide: true,
      // dom: 'Bfrtip',
      buttons: [],
      ajax: "{{ route('users.index') }}",
      "order": [],
      select: {
        style: 'multi'
      },
      columns: [{
          data: 'id',
          name: 'id',
          searchable: false
        },
        {
          data: 'first_name',
          name: 'first_name'
        },
        {
          data: 'last_name',
          name: 'last_name'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'image',
          name: 'image',
          searchable: false
        },
        {
          data: 'actions',
          name: 'actions',
          searchable: false,
          orderable: false,
        }
      ],
    });
  });
</script>
@endpush