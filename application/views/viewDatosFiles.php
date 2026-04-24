

<div class="card mt-3" style="border:none; background-color: #999; ">

    <hr>

    <style>
        table { border-collapse: collapse; margin: 20px; }
        td, th { border: 1px solid #999; padding: 8px; }
    </style>


    <h2>Carpeta de Investigación</h2>
    <table>
        <?php 
        error_reporting(0);
        foreach ($dataTblCarpetas as $i => $row): ?>
        <tr>
            <?php foreach ($row as $cell): ?>
            <td><?= htmlspecialchars($cell) ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>   
    </table>

    <br>


    <h2>Delitos</h2>
    <table>
        <?php 
        error_reporting(0);
        foreach ($dataTblDelitos as $i => $row): ?>
        <tr>
            <?php foreach ($row as $cell): ?>
            <td><?= htmlspecialchars($cell) ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>

</div>  


<div class="row text-left">
    <div class="col">
        <div class="form-group">
            <button  type="button" id="botonInsert_tmp" class="btn boton btn-sm" ><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Validar archivo</button>
        </div>

    </div>
</div>  


<script>

    $("#botonInsert_tmp").click(function(){


            ejecutaPeticionAjaxUploadFiles("POST", "../../ConUploadFiles/insert_tmp/", "contenedorGeneral2", "formUploadFiles")
           
           Swal.fire({
                icon: 'success',
                title: 'Ok',
                text: 'Documentos insertados correctamente'
            })
              

    }) 
    


</script>