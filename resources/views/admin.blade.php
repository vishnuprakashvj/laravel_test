@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-16">
            <div class="card">
                <div class="card-header"> Admin Dashboard</div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table" id="userList">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Address</th>
                            <th scope="col">Options</th>

                            </tr>
                        </thead>
                        <tbody >
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- model box start-->
<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" id="profile_id">
      <div class="modal-body" id="user_details">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateUserDetails()" >Update Profile</button>
      </div>
    </div>
  </div>
</div>


<!-- model box end-->
@push('custom-scripts')
<script>
$( document ).ready(function() {
    getUserList();
});
function getUserList(){
    console.log('get List');
    var formData = new FormData();
    formData.append("_token", '{{ csrf_token()}}');
    $.ajax({
                type: "POST",
                url: '{{ route('admin.usersList')}}',
                data: formData,
                dataType: 'json',                                      
                processData: false,
                contentType: false,
                success: function(data){                   
                    if(data.status){

                        console.log(data);
                        var userList = data.data;
                        var tableBody = "";
                            var count = 0;
                            userList.forEach(function(user) {
                                count = count+1;
                                var option = "";
                                var phone = (user.phone !=null) ? user.phone:"NA";
                                var gender = (user.gender !=null) ? user.gender:"NA";
                                var address = (user.address !=null) ? user.address:"NA";

                                option =  option + '<div class="btn-group" role="group" aria-label="Basic example">'
                                    +'<button onclick="editUser('+user.uid+')" type="button" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'
                                    +'<button onclick="deleteUser('+user.uid+')" type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                    +'</div>';
                                tableBody = tableBody+"<tr id='row_"+user.uid+"' scope='row'>"
                                        +"<td>"+count+"</td>"
                                        +"<td id='col_name_"+user.uid+"'>"+user.name+"</td>"
                                        +"<td id='col_email_"+user.uid+"'>"+user.email+"</td>"
                                        +"<td id='col_phone_"+user.uid+"'>"+phone+"</td>"
                                        +"<td id='col_gender_"+user.uid+"'>"+gender+"</td>"
                                        +"<td id='col_address_"+user.uid+"'>"+address+"</td>"
                                        +"<td>"+option+"</td>"
                                        +"</tr>";
                   
                             console.log(user);
                            });
                            $('#userList tbody').append(tableBody);
                            
                    }else
                    {
                   
                        console.log('error');
                
                    }
                    
                }
            });
}
function deleteUser(usreId){
  
    var formData = new FormData();
    formData.append("_token", '{{ csrf_token()}}');
    formData.append("user_id", usreId);
    $.ajax({
        type: "POST",
        url: '{{ route('admin.deleteUser')}}',
        data: formData,
        dataType: 'json',                                      
        processData: false,
        contentType: false,
        success: function(data){                   
            if(data.status){
                 var row = document.getElementById("row_"+usreId);
                 row.parentNode.removeChild(row);
            }
        }
    });
}
function editUser(userId){
    $('#profile_id').val(userId);
    $('#userEditModal').modal('show');
    $.ajax({
                type: "POST",
                url: '{{ route('edit.profile')}}',
                data: {'cust_id':userId,'_token':'{{ csrf_token()}}'},
                dataType: 'html',                                     
                
                success: function(data){
                    $('#user_details').html(data);
                
                }
            });
}
function updateUserDetails(){
    var profile_id = $('#profile_id').val();
    event.preventDefault(); 
        var form = document.getElementById('user_edit');
        var formData = new FormData(form);
        
        formData.append("_token", '{{ csrf_token()}}');
        formData.append("uid", profile_id);

        $.ajax({
            type: "POST",
                url: '{{ route('update.profile')}}',
                data: formData,
                dataType: 'json',                                      
                processData: false,
                contentType: false,
                success: function(data){                   
                    if(data.success){

                        updateTableRow(data.userinfo,profile_id);
                        $('#userEditModal').modal('hide');

                    }else
                    {
                       
                        $('#userEditModal').modal('hide');
                   
                
                    }
                    
                }
            });
}
function updateTableRow(data,profile_id){

    $('#col_name_'+profile_id).html(data.user_name); 
    $('#col_phone_'+profile_id).html(data.phone); 
    $('#col_address_'+profile_id).html(data.address); 
    $('#col_gender_'+profile_id).html(data.gender); 

}
</script>
@endpush
@endsection

