@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Event has been added!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

     @endif
     <div class="row text-right">
         <div class="col-12">
             <button type="button" class="btn btn-primary mb-2 text-right" data-toggle="modal" data-target="#creatEventModal">
                Create Event
             </button>
         </div>
     </div>
    <!-- Modal -->
    <div class="modal modal-primary fade" tabindex="-1" role="dialog" aria-hidden="true" id="creatEventModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create Event</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="{{route('events.store')}}">
              @csrf
              <div class="modal-body">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Title</label>
                      <input required type="text" name="title" class="form-control" placeholder="Enter title">
                    </div>
                    <div class="row">
                      <div class="col">
                          <label>Start Date</label>
                        <input required type="text" class="datepicker form-control" id="startdate" name="startdate" autocomplete="off">
                      </div>
                      <div class="col">
                          <label>End Date</label>
                        <input required type="text" class="datepicker form-control" id="enddate" name="enddate" autocomplete="off">
                      </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Appointment</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="post" action="events/updateEvent">
                    @csrf
                    <input hidden id="event_id" name="event_id" />
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Title</label>
                          <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="row">
                          <div class="col">
                              <label>Start Date</label>
                            <input required type="text" class="datepicker form-control" name="start_date" id="start_date" autocomplete="off">
                          </div>
                          <div class="col">
                              <label>End Date</label>
                            <input required type="text" class="datepicker form-control" name="end_date" id="end_date" autocomplete="off">
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">Full Calendar Example</div> --}}

                <div class="panel-body">
                    <div id="calendar">

                    </div>
                    {{-- {!! $calendar->calendar() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
  $(document).ready(function(){
           $('.datepicker').datepicker({
               autoclose: true,
                format: 'yyyy-mm-dd',
            });


           $('#calendar').fullCalendar({
               header: {
   				left: 'prev,next today',
   				center: 'title',
   				right: 'month,agendaWeek,agendaDay'
   			},
                events : [
                    @foreach($data as $event)
                    {
                        title : '{{ $event->title}}',
                        start : '{{ $event->start_date }}',
                        id : '{{ $event->id }}',
                        @if ($event->end_date)
                                end: '{{ $event->end_date }}',
                        @endif
                    },
                    @endforeach
                ],
                eventClick: function(calEvent, jsEvent, view) {
                    $('#title').val(calEvent.title);
                    $('#start_date').val(moment(calEvent.start).format('YYYY-MM-DD'));
                    $('#event_id').val(calEvent.id);
                    $('#end_date').val(moment(calEvent.end).format('YYYY-MM-DD'));
                    $('#editModal').modal();
                }
            });

  });
</script>

{{-- {!! $calendar->script() !!} --}}

@endsection
