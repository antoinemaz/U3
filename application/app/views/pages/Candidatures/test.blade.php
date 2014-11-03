@extends('template')

@section('content')

       <script type="text/javascript">
      window.onload = function (){

        <?php

          $count = 0;

          foreach ($pieces as $key => $value) {
            $count++;
            ?>
            // Javascript : instance d'un objet PDFObject pour l'affichage du PDF dans la page
            var myPDF = new PDFObject({ url: 'uploads/<?php echo $value->uid ?>' })
            .embed('pdf'+<?php echo $count;  ?> );
            <?php
          }

        ?>

      };
    </script>

    <?php

      for ($i=1; $i <= $count ; $i++) { 
         ?>
          <div id="pdf{{$i}}"></div>
         <?php
      }
    ?>
    
@stop