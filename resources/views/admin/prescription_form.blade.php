<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.body{
			width: 80%;
			margin: auto;
		}
		.txtCenter{
			text-align: center;
		}
		.clm{
			width: 100%;
		}
		.left-clm{
			float: left;
			width: 35%;
		}
		.right-clm{
			float: left;
			width: 65%;
		}
		hr
		{ 
		  display: block;
		  margin-top: 0.5em;
		  margin-bottom: 0.5em;
		  margin-left: auto;
		  margin-right: auto;
		  border-style: inset;
		  border-width: 1px;
		}
		.rx{
			font-weight: bold;
			font-size: 40px;
		}
		.prescribe{
			margin-left: 30%;
			font-family: cursive;
		}
		.advice{
			margin-top:70px;
			margin-left: 10%;
			font-family: cursive;
		}
		.sign{
			margin-top: 50px;
			float: right;
		}
	</style>
</head>
<body>
	<div class="body"> 

		<div class="txtCenter">
			<h3>Dr. {{ $appointment->doctors->name }} </h3>
			<p> Dhaka, Bangladesh</p>
			<p> Reg.-123455</p>
		</div>
		<p><span style="font-weight:bold;font-size:15px" > Clinic Schedule  </span> <br>Moday 01:30PM - 05:00PM  | Tue-Thus 01:30PM - 05:00PM | Friday 01:30PM - 05:00PM | Friday 01:30PM - 05:00PM | Sunday 01:30PM - 05:00PM </p>
		<hr>
		<div class="clm">
			<p><strong>Patient Name : </strong><u>{{ $appointment->users->name }} </u></p>
			<p><strong>Address : </strong><u></u></p>
			<p><span><strong>Age:</strong><u>{{ $appointment->users->age }} </u></span>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span><strong>Sex: </strong><u>{{ $appointment->users->gender }}</u></span>
			<span style="float:right;"><strong> Date: <span style="color:red"><u> {{ date('j F Y', strtotime($appointment->follow_up_visit_date)) }}</u></span></strong></span></p>
		</div>
		
		<div class="clm">
			<div class="left-clm">
				<div class="advice">
				<strong><u>Symptoms</u></strong>
				<p> @php $patient_symptoms = explode(",",$appointment->patient_symptoms);@endphp  @foreach($patient_symptoms as $sinfo)
					<p>{{ $sinfo }}</p>
				@endforeach </p> 

				@if($appointment->cc)
					<strong><u>Investigation</u></strong>
					<p> @php $investigation = explode(",",$appointment->investigation);@endphp  @foreach($investigation as $iinfo)
					<p>{{ $iinfo }}</p>
				@endforeach </p> 
				@endif

				@if($appointment->cc)
					<strong><u>CC</u></strong><br>
					<p> @php $cc = explode(",",$appointment->cc);@endphp  @foreach($cc as $cinfo)
					<p>{{ $cinfo }}</p>
				@endforeach </p> 
				@endif
				</div>
			</div>
			<div class="right-clm">
			<p class="rx">R<span style="font-size:20px">x</span></p>
				<div class="prescribe">
				<p> @php $medicine = explode(",",$appointment->prescribe_medicines);@endphp  @foreach($medicine as $info)
					<p>{{ $info }}</p>
				@endforeach </p> 
			</div>

			<div class="sign">
			<p>Physician Sig:_______________</p>
			<p>Lic No:____________________</p>
			<p>PTR No:___________________</p>
			<p>S2 No:_____________________</p>
		</div>
			</div>
			
		</div>
		
	</div>
</body>
</html> -->



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.body{
			width: 80%;
			margin: auto;
		}
		.txtCenter{
			text-align: center;
		}
		.clm{
			width: 100%;
		}
		.left-clm{
			float: left;
			width: 35%;
		}
		.right-clm{
			float: left;
			width: 65%;
		}
		hr
		{ 
		  display: block;
		  margin-top: 0.5em;
		  margin-bottom: 0.5em;
		  margin-left: auto;
		  margin-right: auto;
		  border-style: inset;
		  border-width: 1px;
		}
		.rx{
			font-weight: bold;
			font-size: 40px;
		}
		.prescribe{
			margin-left: 30%;
			font-family: cursive;
		}
		.advice{
			margin-top:70px;
			margin-left: 10%;
			font-family: cursive;
		}
		.sign{
			margin-top: 70px;
			float: right;
		}
		.visitdate{
			margin-top: 70px;
		}
	</style>
</head>
<body>
	<div class="body"> 

		<div class="txtCenter">
			<h3>{{ $appointment->doctors->name }}<br> <span style="font-size:12px">{{ doctor_degree_details($appointment->doctors->id) }} </span></h3>
			<p> {{ $appointment->doctors->address }}</p>
			<p> Phone-{{ $appointment->doctors->phone }}</p>
		</div>
		<p><span style="font-weight:bold;font-size:12px" > Clinic Schedule  </span></p>
		<table style="width:100%;font-size: 8px;" class="txtCenter">
		<tr>
		<th>Saturday</th>
		<th>Sunday</th>
		<th>Monday</th>
		<th>Tuesday</th>
		<th>Wednesday</th>
		<th>Thursday</th>
		<th>Friday</th>
		</tr>
		<tr>
		<td>01:30PM - 02:30PM</td>
		<td>03:30PM - 04:30PM</td>
		<td>04:30PM - 06:30PM</td>
		<td>01:30PM - 02:30PM</td>
		<td>01:30PM - 02:30PM</td>
		<td>03:30PM - 04:30PM</td>
		<td>04:30PM - 06:30PM</td>
		</table>
		<hr>
		<div class="clm">
			<p><strong>Patient Name : </strong><u>{{ $appointment->users->name }} </u></p>
			<p><strong>Address : </strong><u>{{ $appointment->users->address }}</u></p>
			<p><span><strong>Age: </strong><u>{{ $appointment->users->age }} </u></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span><strong>Sex: </strong><u>{{ $appointment->users->gender }}</u></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span><strong>Weight: </strong><u>{{ $patient_weight }} </u></span>
			<span style="float:right;"><strong> Date: <span><u> {{ date('j F Y', strtotime($appointment->visit_date)) }}</u></span></strong></span></p>
		</div>
		
		<div class="clm">
			<div class="left-clm">
				<div class="advice">
				<strong><u>Diagnosis</u></strong>
				<p> @php $patient_symptoms = explode(",",$appointment->patient_symptoms);@endphp  @foreach($patient_symptoms as $sinfo)
					<p>{{ $sinfo }}</p>
				@endforeach </p> 

				@if($appointment->cc)
					<strong><u>Investigation</u></strong>
					<p> @php $investigation = explode(",",$appointment->investigation);@endphp  @foreach($investigation as $iinfo)
					<p>{{ $iinfo }}</p>
				@endforeach </p> 
				@endif

				@if($appointment->cc)
					<strong><u>CC</u></strong><br>
					<p> @php $cc = explode(",",$appointment->cc);@endphp  @foreach($cc as $cinfo)
					<p>{{ $cinfo }}</p>
				@endforeach </p> 
				@endif
				</div>
				@if($appointment->follow_up_visit_date)
				<div class="visitdate">
			<p>Next Visit : <span style="color:red"><u> {{ date('j F Y', strtotime($appointment->follow_up_visit_date)) }}</u></p>
		</div>
		@endif
			</div>
			<div class="right-clm">
			<p class="rx">R<span style="font-size:20px">x</span></p>
				<div class="prescribe">
				<p> @php $medicine = explode(",",$appointment->prescribe_medicines);@endphp  @foreach($medicine as $info)
					<p>{{ $info }}</p>
				@endforeach </p> 
			</div>
			<div style="margin-left:100px;font-family: cursive;">{{ $appointment->instructions }}</div>


			<div class="sign">
			@php $profesion = doctor_professional_info($appointment->doctors->id); @endphp
			<p>Physician Sig:_______________</p>
			@if($profesion['registration_no']) <p>Reg. No: <u>@php echo $profesion['registration_no'] @endphp</u></p> @endif
			@if($profesion['licence_no'])<p>Lic. No: <u>@php echo $profesion['licence_no'] @endphp</u></p> @endif
			@if($profesion['ptr_no'])<p>PTR No: <u>@php echo $profesion['ptr_no'] @endphp</u></p> @endif
			@if($profesion['s2_no'])<p>S2 No: <u>@php echo $profesion['s2_no'] @endphp</u></p> @endif
		</div>
			</div>
			
		</div>
		
	</div>
</body>
</html>