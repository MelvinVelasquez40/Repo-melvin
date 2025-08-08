<h1 class="section-title">Recomendaciones de Medicamentos</h1>

<!-- Enlace para agregar nuevo -->
<div class="actions">
  <a href="index.php?page=Medicamentos_RecordatorioForm&mode=INS" class="btn-add-new">Agregar Nuevo</a>
</div>

<div class="recommendation-list">
  {{foreach recordatorios}}
    <div class="recommendation-card" data-id="{{id}}">
      <h2>Paciente: {{nombre_usuario}} ({{edad}} años)</h2>
      <p><strong>Familiar:</strong> {{nombre_familiar}}</p>
      <p><strong>Email:</strong> {{email_familiar}}</p>
      <p><strong>Teléfono:</strong> {{telefono_familiar}}</p>
      <p><strong>Frecuencia de dosis:</strong> {{frecuencia_dosis}}</p>
      <p><strong>Comentario:</strong> {{comentario}}</p>

      <!-- Botones con enlaces para editar y eliminar -->
      <div class="actions">
        <a href="index.php?page=Medicamentos_RecordatorioForm&mode=UPD&id={{id}}" class="btn-edit">Editar</a>
        <a href="index.php?page=Medicamentos_RecordatorioForm&mode=DEL&id={{id}}" class="btn-delete" onclick="return confirm('¿Seguro que quieres eliminar este registro?');">Eliminar</a>
      </div>
    </div>
  {{endfor recordatorios}}
</div>
