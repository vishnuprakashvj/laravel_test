<form enctype="multipart/form-data" method="post" id="user_edit">
@csrf
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ ($profileData!= null &&$profileData->user_name != null) ? $profileData->user_name : 'NA'}}">
            <span class="text-danger err_clear" id="name_error"></span>
          </div>
          @if($profileData!= null &&$profileData->email != null)
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email" disabled value="{{ ($profileData!= null &&$profileData->email != null) ? $profileData->email : NA}}">
          </div>
          @endif
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ ($profileData!= null &&$profileData->phone != null) ? $profileData->phone : 'NA'}}">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Gender:</label>
            <select class="form-control" name="gender">
                <option value="male" <?= (($profileData!= null &&$profileData->gender == 'male')?'selected':'')?>>Male</option>
                <option value="female" <?= (($profileData!= null &&$profileData->gender == 'female')?'selected':'')?>>Female</option>
                <option value="other" <?= ($profileData!= null && $profileData->gender=='other'?'selected':'')?>>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Address:</label>
            <textarea class="form-control" id="address" name="address">{{ ($profileData!= null &&$profileData->address != null) ? $profileData->address : 'NA'}}</textarea>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">profile image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <input type="hidden" value="{{($profileData!= null &&$profileData->user_id != null) ? $profileData->user_id : Auth::user()->id}}" name="user_id" id="user_id"/> 
          </div>
        </form>