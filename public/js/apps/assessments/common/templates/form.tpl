<form>
  <div class="control-group">
    <label for="fund-firstName" class="control-label">First name:</label>
    <input id="fund-firstName" name="firstName" type="text" value="<%= firstName %>"/>
  </div>
  <div class="control-group">
    <label for="fund-lastName" class="control-label">Last name:</label>
    <input id="fund-lastName" name="lastName" type="text" value="<%= lastName %>"/>
  </div>
  <div class="control-group">
    <label for="fund-phoneNumber" class="control-label">Phone number:</label>
    <input id="fund-phoneNumber" name="phoneNumber" type="text" value="<%= phoneNumber %>"/>
  </div>
  <button class="btn js-submit">Save</button>
</form>
