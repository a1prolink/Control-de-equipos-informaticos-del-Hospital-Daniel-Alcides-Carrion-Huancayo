document.getElementById('organizacion').addEventListener('change', function() {
    let organizacionId = this.value;
    fetch('get_suborganizaciones.php?organizacion_id=' + organizacionId)
        .then(response => response.json())
        .then(data => {
            let suborganizacionSelect = document.getElementById('suborganizacion');
            suborganizacionSelect.innerHTML = '<option value="">Seleccionar suborganización</option>';
            data.forEach(suborg => {
                suborganizacionSelect.innerHTML += `<option value="${suborg.id}">${suborg.nombre}</option>`;
            });
        });
});
document.getElementById('suborganizacion').addEventListener('change', function() {
    let suborganizacionId = this.value;
    fetch('get_subsuborganizaciones.php?suborganizacion_id=' + suborganizacionId)
        .then(response => response.json())
        .then(data => {
            let subsuborganizacionSelect = document.getElementById('subsuborganizacion');
            subsuborganizacionSelect.innerHTML = '<option value="">Seleccionar sub-suborganización</option>';
            data.forEach(subsuborg => {
                subsuborganizacionSelect.innerHTML += `<option value="${subsuborg.id}">${subsuborg.nombre}</option>`;
            });
        });
});
