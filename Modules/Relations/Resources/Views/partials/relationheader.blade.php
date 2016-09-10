<div class="col-md-6">

  <h1 class="moveup">{{$relation->name}} ({{$relation->company_name}})</h1>

  <!--Relation info leftside-->
  <div class="contactleft">
    @if($relation->email != "")
      <!--MAIL-->
    <p><span class="glyphicon glyphicon-envelope" aria-hidden="true" data-toggle="tooltip" title="Email"
             data-placement="left"> </span>
      <a href="mailto:{{$relation->email}}" data-toggle="tooltip" data-placement="left">{{$relation->email}}</a></p>
    @endif
    @if($relation->primary_number != "")
      <!--Work Phone-->
    <p><span class="glyphicon glyphicon-headphones" aria-hidden="true" data-toggle="tooltip" title="Primary number"
             data-placement="left"> </span>
      <a href="tel:{{$relation->work_number}}">{{$relation->primary_number}}</a></p>
    @endif
    @if($relation->secondary_number != "")
      <!--Secondary Phone-->
    <p><span class="glyphicon glyphicon-phone" aria-hidden="true" data-toggle="tooltip" title="Secondary number"
             data-placement="left"> </span>
      <a href="tel:{{$relation->secondary_number}}">{{$relation->secondary_number}}</a></p>
    @endif
    @if($relation->address || $relation->zipcode || $relation->city != "")
      <!--Address-->
    <p><span class="glyphicon glyphicon-home" aria-hidden="true" data-toggle="tooltip" title="Address/Zip code/city"
             data-placement="left"> </span> {{$relation->address}} <br/>{{$relation->zipcode}} {{$relation->city}}
    </p>
    @endif
  </div>

  <!--Relation info leftside END-->
  <!--Relation info rightside-->
  <div class="contactright">
    @if($relation->company_name != "")
      <!--Company-->
    <p><span class="glyphicon glyphicon-star" aria-hidden="true" data-toggle="tooltip" title="Company name"
             data-placement="left"> </span> {{$relation->company_name}}</p>
    @endif
    @if($relation->vat != "")
      <!--Company-->
    <p><span class="glyphicon glyphicon-cloud" aria-hidden="true" data-toggle="tooltip" title="VAT number"
             data-placement="left"> </span> {{$relation->vat}}</p>
    @endif
    @if($relation->industry != "")
      <!--Industry-->
    <p><span class="glyphicon glyphicon-briefcase" aria-hidden="true" data-toggle="tooltip" title="Industry"
             data-placement="left"> </span> {{$relation->industry}}</p>
    @endif
    @if($relation->company_type!= "")
      <!--Company Type-->
    <p><span class="glyphicon glyphicon-globe" aria-hidden="true" data-toggle="tooltip" title="Company type"
             data-placement="left"> </span>
      {{$relation->company_type}}</p>
    @endif
  </div>
</div>

<!--Relation info rightside END-->
