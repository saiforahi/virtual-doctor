<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
        <label for="slot_id">Time Schedule </label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7" >
<div class="form-group">
            <select class="form-control schedule" onkeyup="createSchedule()" onchange="createSchedule()" name="slot_id" id="slot_id" required oninvalid="this.setCustomValidity('Enter a schedule')"
    oninput="this.setCustomValidity('')">
                <option value="">Select Time Schedule</option>
                {{-- <option value="create_schedule">Create Time Schedule</option> --}}
                @foreach($slot as $data)            
                <option value="{{ $data->id }}">{{ $data->day_name  }} {{ date('h:i:s A', strtotime($data->start_time)) }} - {{ date('h:i:s A', strtotime($data->end_time)) }}</option>
                @endforeach                                            
            </select>
        </div>
        </div>