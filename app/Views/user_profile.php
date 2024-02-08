<!DOCTYPE html>
<html>

<style>
#map {
      height: 450px;
      width: 600px;
    }
</style>

</body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3 class="text-center">
			<?php echo $user['username']; ?>
			</h3>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-2 column">
			<dl>
				<dt>
					User ID: 
				</dt>
				<dd>
					<?php echo $user['id']; ?>
				</dd>
				<dt>
					User Name:
				</dt>
				<dd>
                    <?php echo $user['username']; ?>
				</dd>
				<dt>
					Email Address:
				</dt>
				<dd>
                    <?php echo $user['email']; ?>
				</dd>
				<dt>
					Role:
				</dt>
				<dd>
                    <?php echo $role; ?>
				</dd>
			</dl>
		</div>

		<div class="col-md-6 column d-flex align-items-center justify-content-center">
            <div class = "courses">
				<h3 class="text-center">The Related Course List</h3>    
                <ul>
				<?php
				if($course_names == "The course list is empty now") {
					echo $course_names;
				} else {
					foreach($course_names as $course)
					{     
						echo '<li>';
						if($role == "teacher"){
							echo $course['title'];
						} else {
							//student's favorite is the course id 
							echo $course['title'];
						}
						
						echo '</li>';
					}
				}
				
				?>    
			    </ul>
			</div>
		</div>

		<div class="col-md-4 column">
            <?php echo form_open(base_url().'user/update_information'); ?>
				<h3 class="text-center">Update Your Eamil Address</h3>       
				
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Email" required="required" name="email">
					</div>
					
					<div class="form-group">
						<?php if (isset($error)): ?>
							<?php echo $error; ?>
							<?php endif; ?>
						<?php if (isset($success)): ?>
							<?php echo $success;?>
							<?php endif; ?>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Update</button>
					</div>  
			<?php echo form_close(); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-4 column">
		<h3 class="text-center">
			Show Your Address
		</h3>
		<p>Click the button to get your coordinates and display them on the map.</p>
		<button onclick="getLocation()">Try It</button><br>
		<div id="map"></div>
		<p id="demo"></p>
		</div>
	</div>
</div>

<script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude +
  "<br>Longitude: " + position.coords.longitude;

  var pos = {
    lat: position.coords.latitude,
    lng: position.coords.longitude,
  };

  var iframeSrc = "https://www.google.com/maps/embed/v1/place?key=AIzaSyAkVU0Ve13fbhfpifhCH25gce54N4VEjuU&q=" + pos.lat + "," + pos.lng;

  document.getElementById("map").innerHTML = '<iframe src="' + iframeSrc + 
  '" width=650 height="400" frameborder="0" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade""></iframe>';
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "User denied the request for Geolocation."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "Location information is unavailable."
      break;
    case error.TIMEOUT:
      x.innerHTML = "The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML = "An unknown error occurred."
      break;
  }
}
</script>

</body>

</html>