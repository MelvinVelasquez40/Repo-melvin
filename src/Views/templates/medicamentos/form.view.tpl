<section class="Lista_Contenedor">
  <h2>{{modeDsc}}</h2>
  <form class="Lista_Formulario" action="index.php?page=Medicamentos_RecordatorioForm&mode={{mode}}&id={{id}}"
    method="post">
    
    <legend>Formulario de Recordatorio</legend>
    <div class="Lista_Box">
      <!-- Campos ocultos -->
      <div>
        <input type="hidden" name="mode" value="{{mode}}">
        <input type="hidden" name="cxfToken" value="{{cxfToken}}">
      </div>

      <!-- Campo ID (oculto) -->
      <div style="display: none;">
        <label for="id">ID</label>
        <input type="text" name="id" id="id" value="{{id}}" readonly>
      </div>

      <!-- Nombre del usuario -->
      <div>
        <label for="nombre_usuario">Nombre del Usuario</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" value="{{nombre_usuario}}" {{isReadOnly}} required>
      </div>

      <!-- Edad -->
      <div>
        <label for="edad">Edad</label>
        <input type="number" name="edad" id="edad" value="{{edad}}" {{isReadOnly}} required min="0" max="120">
      </div>

      <!-- Nombre del familiar -->
      <div>
        <label for="nombre_familiar">Nombre del Familiar</label>
        <input type="text" name="nombre_familiar" id="nombre_familiar" value="{{nombre_familiar}}" {{isReadOnly}} required>
      </div>

      <!-- Email del familiar -->
      <div>
        <label for="email_familiar">Email del Familiar</label>
        <input type="email" name="email_familiar" id="email_familiar" value="{{email_familiar}}" {{isReadOnly}} required>
      </div>

      <!-- Teléfono del familiar -->
      <div>
        <label for="telefono_familiar">Teléfono del Familiar</label>
        <input type="tel" name="telefono_familiar" id="telefono_familiar" value="{{telefono_familiar}}" {{isReadOnly}} required>
      </div>

      <!-- Frecuencia de dosis -->
      <div>
        <label for="frecuencia_dosis">Frecuencia de la Dosis</label>
        <input type="text" name="frecuencia_dosis" id="frecuencia_dosis" value="{{frecuencia_dosis}}" {{isReadOnly}} required>
      </div>

      <!-- Comentario -->
      <div>
        <label for="comentario">Comentario</label>
        <textarea name="comentario" id="comentario" rows="4" {{isReadOnly}}>{{comentario}}</textarea>
      </div>

      <!-- Botones de acción -->
      <div>
        {{if showActions}}
        <input type="submit" value="Guardar" {{isReadOnly}} class="btn-guardar">
        {{endif showActions}}
        {{if noActions}}
        <input type="button" value="Imprimir" onclick="window.print()" class="btn-guardar">
        {{endif noActions}}
        <input style="display: none;" type="button" value="Cancelar"
          onclick="location.href='index.php?page=Medicamentos_RecordatorioList'">
      </div>
    </div>

  </form>
</section>
