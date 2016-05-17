@if(Session::has('message'))

  @if(Session::has('type_message'))

    <?php $type_message = Session::get('type_message') ?>

    @if($type_message == "warning")
        <?php $type_message_icon = "fa fa-exclamation-triangle" ?>
    @elseif($type_message == "error")
      <?php $type_message_icon = "fa fa-exclamation-triangle" ?>
    @elseif($type_message == "success")
      <?php $type_message_icon = "fa fa-check-circle" ?>
    @else
      <?php $type_message_icon = "fa fa-info-circle" ?>          
    @endif

  @else
    <?php $type_message = "info" ?>
    <?php $type_message_icon = "fa fa-info-circle" ?>
  @endif

  
  <div id="messageAlert" class="row partial_messages">

    <div class="col-lg-8 col-md-offset-2">

      <div id="messAlert" class="alert alert-{{$type_message}}" style='margin-top:20px;margin-bottom:40px;'>
        <button type="button" class="close" data-dismiss="alert" data-target="#messageAlert">&times;</button>
        <i class="{{$type_message_icon}}"></i>
        {{ Session::get('message') }}
        <br>
        @if(Session::has('error_code'))
          <b>{{ trans('web.error_code')}}: {{Session::get('error_code')}}</b>
        @endif
        
      </div>
      
    </div>

  </div>

@endif