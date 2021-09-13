@extends('layouts.layouts')
@section('title', 'Create | Field Visits')
@section('content')
    {{--<style>--}}
        {{--.visitors-form  .form-control{--}}
            {{--height:25px;--}}
        {{--}--}}
    {{--</style>--}}
<section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="{{route('daily-field-visits.index')}}">Field Visit</li>
            <li class="active">Field Visit Create</li>
        </ol>
</section>

    <!-- Main content -->
<section class="content">
    @include('message.flash-message')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create New Field Visit</h3>
                    <div class="box-tools pull-right">
                        {{--@include('user.partials.user-header-buttons')--}}
                        <a href="{{route('next-field-visits.create')}}" class="label label-primary">Create Next Field Visit</a>
                        <a href="{{route('daily-field-visits.index')}}" class="label label-info">List All Field Visit</a>

                    </div><!--box-tools pull-right-->
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" class="visitors-form" method="POST" action="{{route('daily-field-visits.store')}}">
                    <div class="box-body">
                        {{csrf_field()}}
                        <div class="col-md-6 col-sm-6 col-lg-12">
                            <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                    <label>Date <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>

                                    @role(['marketingOfficer', 'marketingBoy'])
                                        <div class="input-group date">
                                            <p>{{ date('Y-m-d') }}</p>
                                            <input type="hidden" class="form-control pull-right form_date" name="date" value="{{ date('Y-m-d') }}">
                                        </div>
                                    @else
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>

                                          <input type="date" class="form-control pull-right form_date" name="date"  value="{{ !empty(old('date'))? old('date') : date("Y-m-d") }}">
                                        </div>
                                        @if ($errors->has('date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                                        @endif
                                    @endrole

                                    
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}" id="office">
                                    <label for="office_name">Office Name <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                    <div id="officeMsg"></div>
                                    <a href="#" class="add-new-office pull-right">Add New Office</a>
                                    <select class="form-control office_name" id="company_id" name="company_id">
                                        <option value="">---</option>
                                        @forelse($companies as $company)
                                            <option value="{{ $company->id }}" {{ (old("company_id") == $company->id ? "selected":"") }}>{{ $company->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('company_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('company_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('visit_category_id') ? ' has-error' : '' }}">
                                    <label for="visit_category_id" class="col-lg-2">Category <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                    <select name="visit_category_id" id="visit_category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @forelse($visitCategories as $category)
                                            <option value="{{ $category->id }}" {{ (old("visit_category_id") == $category->id ? "selected":"") }}>{{ $category->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('visit_category_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('visit_category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }} ">
                                    <label for="email_address">Email Address <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter email address" value="{{ old('email_address') }}">
                                    </div>
                                    @if ($errors->has('email_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} ">
                                    <label for="address">Address <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <input type="address" class="form-control" name="address" placeholder="Enter address" value="{{ old('address') }}">
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('visited_to') ? ' has-error' : '' }}">
                                    <label for="visited_to">Visited To <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                    <input type="text" class="form-control" id="visited_to" name="visited_to" placeholder="visited to" value="{{ old('visited_to') }}">
                                    @if ($errors->has('visited_to'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('visited_to') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-12" id="visitor-contacts">
                                <div class="form-group {{ $errors->has('visitors_contact') ? ' has-error' : '' }}">
                                    <label for="visitors_contact">Visitor Contact
                                    </label>
                                    <a id="add-visitor-contact" class="label label-primary" style="float: right;">+ Add More</a>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control" id="visitors_contact" name="visitors_contact[]" placeholder="visitors contact" value="">
                                    </div>
                                    @if ($errors->has('visitors_contact'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('visitors_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-12" id="visitor-emails">
                                <div class="form-group {{ $errors->has('visitors_email') ? ' has-error' : '' }}">
                                    <label for="visitors_email">Visitor Email </label>
                                    <a href="#" id="add-visitor-email" class="label label-primary" style="float: right;">+ Add More</a>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="text" class="form-control" id="visitors_email" name="visitors_email[]" placeholder="visitors email" value="">
                                    </div>
                                    @if ($errors->has('visitors_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('visitors_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                    <label for="contact_person">Contact Person <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact person name" value="">
                                    @if ($errors->has('contact_person'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact_person') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12" id="contact-numbers">
                                <div class="form-group {{ $errors->has('contact_number') ? ' has-error' : '' }}">
                                    <label for="contact_number">Contact Number</label>
                                    <a href="#" id="add-contact-number" class="label label-primary" style="float: right;">+ Add More</a>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number[]" placeholder="Contact Number" value="">
                                    </div>
                                    @if ($errors->has('contact_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--<div class="col-md-6 col-sm-6 col-lg-12">--}}
                                {{--<div class="form-group {{ $errors->has('targets_id') ? ' has-error' : '' }}">--}}
                                    {{--<label for="targets_id">Target <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>--}}
                                    {{--<select class="form-control select2" name="targets_id" style="width: 100%;">--}}
                                        {{--<option value="">--Select Category--</option>--}}
                                        {{--@forelse($targets as $target)--}}
                                            {{--<option value="{{ $target->id }}">{{ $target->name }}</option>--}}
                                        {{--@empty--}}
                                        {{--@endforelse--}}
                                    {{--</select>--}}
                                    {{--@if ($errors->has('targets_id'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('targets_id') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="col-md-6 col-sm-6 col-lg-12" id="contact-emails">
                                <div class="form-group {{ $errors->has('contact_email') ? ' has-error' : '' }}">
                                    <label for="contact_email">Contact Email</label>
                                    <a href="#" id="add-contact-email" class="label label-primary" style="float: right;">+ Add More</a>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="text" class="form-control" id="contact_email" name="contact_email[]" placeholder="Contact Email" value="">
                                    </div>
                                    @if ($errors->has('contact_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('requirements') ? ' has-error' : '' }}">
                                    <label for="requirements">Requirements</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="requirements" id="requirements" >{{ old('requirements') }}</textarea>
                                    @if ($errors->has('requirements'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('requirements') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label>Next Visit Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-right form_date" name="next_visit_date" id="datepicker1" value="{{ old('next_visit_date') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('project_scope') ? ' has-error' : '' }}">
                                    <label>Project Scope<a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label><br>
                                    <input type="radio" name="project_scope" value="high" class="flat-red" {{ (old("project_scope") == 'high' ? "checked":"") }}>High
                                    <input type="radio" name="project_scope" value="medium" class="flat-red" {{ (old("project_scope") == 'medium' ? "checked":"") }}>Medium
                                    <input type="radio" name="project_scope" value="low" class="flat-red" {{ (old("project_scope") == 'low' ? "checked":"") }}>Low
                                    @if ($errors->has('project_scope'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('project_scope') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('weakness') ? ' has-error' : '' }}">
                                    <label for="requirements">Your any weakness here</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="weakness" id="weakness" >{{ old('weakness') }}</textarea>
                                    @if ($errors->has('weakness'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('weakness') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12">
                                <div class="form-group {{ $errors->has('comments') ? ' has-error' : '' }}">
                                    <label for="Comments">Comments</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="comments" id="comments" >{{ old('comments') }}</textarea>
                                    @if ($errors->has('comments'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('comments') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group {{ $errors->has('project_status') ? ' has-error' : '' }}">
                                    <label>How do you feel this project ? <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label><br>
                                    <label><input type="radio" onclick="javascript:yesnoCheck();" id="yes" name="project_status" value="1" class="flat-red" {{ (old('project_status') == '1' ? "checked" : '') }}>Positive</label>
                                    <label><input type="radio" onclick="javascript:yesnoCheck();" id="no" name="project_status" value="0" class="flat-red" {{ (old('project_status') == '0' ? "checked" : '') }}>Negative</label>
                                    @if ($errors->has('project_status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('project_status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-12" style="display: none;" id="reasonss">
                            <div class="form-group {{ $errors->has('reasons') ? ' has-error' : '' }}">
                                <label for="reasons">Why</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." name="reasons" id="reasons" >{{ old('reasons') }}</textarea>
                                @if ($errors->has('reasons'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reasons') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Create new office modal --}}
    @include('company.partials.create-new-office-modal')
        <!-- /.modal-dialog -->
</section>
    <script src="{{asset('js/office-modal.js')}}"></script>
<script type="text/javascript">

   $(document).ready(function(){
       // $('#datepicker').datepicker({
       //     autoclose: true
       // });
       //
       // $('#datepicker1').datepicker({
       //     autoclose: true
       // })

       $(document).on('focus',".form_date", function(){
            $(this).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            });
        });

       $('.office_name').select2();

   });

   function yesnoCheck() {
       if (document.getElementById('yes').checked) {
           document.getElementById('reasonss').style.display = 'block';
       }
       else if(document.getElementById('no').checked) {
           document.getElementById('reasonss').style.display = 'block';
       }
   }
/*
*   Add more visitor contact fields
*/
       $('#add-visitor-contact').on('click',function(event){
           event.preventDefault();
          var visitor_contact_form = '<div class="form-group"><a href="#" class="remove-visitor-contact" style="float: right;"><i class="fa fa-times"></i></a><div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="text" id="visitor_contact" class="form-control" name="visitors_contact[]" placeholder="Visitor Contact"/></div></div>';
           $('#visitor-contacts').append(visitor_contact_form);
       });

       $('#visitor-contacts').on('click','.remove-visitor-contact', function(e){
           e.preventDefault();
           $(this).parent('div').remove();
       });

  /*
   *  // Add more visitor contact fields
   */

       /*
     *   Add more visitor Emails fields
     */
       $('#add-visitor-email').on('click',function(event){
           event.preventDefault();
           var visitor_email_form = '<div class="form-group"><a href="#" class="remove-visitor-email" style="float: right;"><i class="fa fa-times"></i></a><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input type="text" id="visitor_email" class="form-control" name="visitors_email[]" placeholder="Visitor Email"/></div></div>';
           $('#visitor-emails').append(visitor_email_form);
       });

       $('#visitor-emails').on('click','.remove-visitor-email', function(e){
           e.preventDefault();
           $(this).parent('div').remove();
       });

/*
*  // Add more visitor emails fields
*/

 /*
  *   Add more contact numbers fields
  */
       $('#add-contact-number').on('click',function(event){
           event.preventDefault();
           var contact_number_form = '<div class="form-group"><a href="#" class="remove-contact-number" style="float: right;"><i class="fa fa-times"></i></a><div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="text" id="contact_number" class="form-control" name="contact_number[]" placeholder="Contact Number"/></div></div>';
           $('#contact-numbers').append(contact_number_form);
       });

       $('#contact-numbers').on('click','.remove-contact-number', function(e){
           e.preventDefault();
           $(this).parent('div').remove();
       });

       /*
        *  // End Add more contact numbers fields
        */

       /*
       *   Add more contact numbers fields
       */
       $('#add-contact-email').on('click',function(event){
           event.preventDefault(); event.preventDefault();
           var contact_email_form = '<div class="form-group"><a href="#" class="remove-contact-email" style="float: right;"><i class="fa fa-times"></i></a><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input type="text" id="contact_email" class="form-control" name="contact_email[]" placeholder="Contact Email"/></div></div>';
           $('#contact-emails').append(contact_email_form);
       });

       $('#contact-emails').on('click','.remove-contact-email', function(e){
           e.preventDefault();
           $(this).parent('div').remove();
       });

       /*
        *  // End Add more contact numbers fields
        */

</script>
@endsection