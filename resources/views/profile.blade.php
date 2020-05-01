@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile 
                
               
                <a href="#" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat"><i class="fa fa-pencil-square-o float-right" aria-hidden="true" style="font-size:25px" onclick="editCustomerReg('{{Auth::user()->id}}')" ></i></a>
                
                 </div>

                <div class="card-body">
                <a href="#" data-toggle="modal" data-target="#passwordResetModal" data-whatever="@fat"><i class="fa fa-lock float-right" aria-hidden="true" style="font-size:16px" onclick="changePassword('{{Auth::user()->id}}')" >Change Password</i></a>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif
                    <table>
                      <tr>
                      
                     
                       <td>
                       <table class="table table-bordered" width="500">
                   
                    <tbody>
                    
                        <tr>                       
                            <td>name</td>
                            @if($profileData != null && $profileData->user_name != null )
                              <td style="width:350px; !important;" id="user_nane">{{$profileData->user_name}}</td>
                            @else
                            <td style="width:350px; !important;"id="user_nane">NA</td>  
                            @endif
                        </tr>
                        <tr>                       
                            <td>Email </td> 
                            @if($profileData != null && $profileData->user_id != null )
                            <td id="user_email">{{$profileData->getuserDetails($profileData->user_id)->email}}</td>
                            @else
                            <td id="user_nane">NA</td>  
                            @endif
                             
                        </tr>
                        <tr>                       
                            <td>Address</td>
                            @if($profileData != null && $profileData->address != null )
                            <td id="user_address">{{$profileData->address}}</td>
                            @else
                            <td id="user_address">NA</td>  
                            @endif
                        </tr>
                        <tr>                       
                            <td>Phone</td>
                            @if($profileData != null && $profileData->phone != null )
                            <td id="user_phone">{{$profileData->phone}}</td>
                            @else
                            <td id="user_phone">NA</td>  
                            @endif
                        </tr>
                        <tr>                       
                            <td>Gender</td>
                            @if($profileData != null && $profileData->gender != null )
                            <td id="user_gender">{{ ucwords($profileData->gender) }}</td>
                            @else
                            <td id="user_gender">NA</td>  
                            @endif
                        </tr>
                     
                    </tbody>
                    </table>
                       </td>
                       <td>  &nbsp   &nbsp &nbsp &nbsp &nbsp &nbsp      </td>
                       <td  class="text-left" id="user_profile_pic">
                            @if($profileData != null && $profileData->profile_pic != null)
                                <img id="profile_img" style="width:200px;margin-right:-100px;"  src="{{ asset('assets/images/'.$profileData->profile_pic)}}"/>
                            @else
                            
                            <i class="fa fa-user-circle-o" aria-hidden="true" style="font-size:200px;margin-right:-100px;"></i>
                            @endif
                            </td>
                       </td>
                      </tr>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- model box start-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="customer_details">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateCustomerReg()" >Update Profile</button>
      </div>
    </div>
  </div>
</div>


<!-- model box end-->
<div class="modal fade" id="passwordResetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="">
        <form action="#" id="passwordResetForm">
                <input type="hidden" id="userId" name="userId" required>
                <label for="username">Old Password:</label>
                </br>
                <input type="password" id="oldpassword" name="oldpassword" required>
                </br>
                <label for="username">New Password:</label>
                </br>
                <input type="password" id="newpassword" name="newpassword" required>
                </br>
                </br>
                <button style="float:right;" type="button" class="btn btn-success" onclick="updatePassword()">Submit</button>
            <!-- <button class="btn-success" style="float:right;" type="submit"> </button> -->
        </form>
        
        </div>
  </div>
</div>

<div class="text-center">
  <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalSubscriptionForm">Launch
    Modal Subscription Form</a>
</div>
@push('custom-scripts')
<script>


    function editCustomerReg(id){
       
            $.ajax({
                type: "POST",
                url: '{{ route('edit.profile')}}',
                data: {'cust_id':id,'_token':'{{ csrf_token()}}'},
                dataType: 'html',                                     
                
                success: function(data){
                    $('#customer_details').html(data);
                
                }
            });

    }
    function changePassword(id){
      $("#userId").val(id);
    }
    function updatePassword(){
        event.preventDefault(); 
        var form = document.getElementById('passwordResetForm');
        var formData = new FormData(form);
        
        formData.append("_token", '{{ csrf_token()}}');
        $.ajax({
                type: "POST",
                url: '{{ route('update.password')}}',
                data: formData,
                dataType: 'json',                                      
                processData: false,
                contentType: false,
                success: function(data){                   
                    if(data.success === false){

                        alert(data.message);

                    }else
                    {
                        alert(data.message);
                        $('#passwordResetModal').modal('hide');
                   
                
                    }
                    
                }
            });
    }
    function updateCustomerReg(){
        event.preventDefault();     
        var form = document.getElementById('user_edit');
        var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: '{{ route('update.profile')}}',
                data: formData,
                dataType: 'json',                                      
                processData: false,
                contentType: false,
                success: function(data){                   
                    if(data.success === false){

                        showValidationErrors(data.errors);

                    }else
                    {
                    $('#customer_edit').trigger("reset");
                    $('.err_clear').html("");
                    $('#exampleModal').modal('hide');
                    updateProfileData(data.userinfo);
                   
                
                    }
                    
                }
            });
    }

    function showValidationErrors(errors){
        if(errors.name){
            $('#name_error').html(errors.name);
        }else{
            $('#name_error').html(''); 
        }

    }

    function updateProfileData(userinfo){
        $('#user_nane').html(userinfo.user_name);
        $('#user_email').html(userinfo.user_email);
        $('#user_address').html(userinfo.address);
        $('#user_phone').html(userinfo.phone);
        $('#user_gender').html(userinfo.gender);       
        $("#user_profile_pic").html(`
            <img style="width:200px;"  src="/assets/images/${userinfo.profile_pic}"/>
        `);
        $("#profile_img").attr("src","assets/images/"+userinfo.profile_pic);
    }


</script>
    
@endpush
@endsection
