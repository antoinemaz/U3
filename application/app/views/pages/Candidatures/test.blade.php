@extends('template')

@section('content')


    <?php

      for ($i=1; $i <= $count ; $i++) { 
         ?>
          <div id="pdf{{$i}}"></div>
         <?php
      }
    ?>
    
@stop