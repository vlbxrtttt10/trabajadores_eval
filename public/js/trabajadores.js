const API_BASE = window.API_BASE;
const CSRF     = () => $('meta[name="csrf-token"]').attr('content');

Notiflix.Notify.init({ position: 'right-top', timeout: 4000, borderRadius: '6px', fontSize: '14px' });
Notiflix.Loading.init({ svgColor: '#0d6efd' });

function estadoBadge(estado) {
    return estado === 'activo'
        ? '<span class="badge badge-activo">Activo</span>'
        : '<span class="badge badge-inactivo">Inactivo</span>';
}

function botonEstado(id, nombre, estado) {
    if (estado === 'activo') {
        return `<button class="btn btn-sm btn-danger btn-accion" onclick="toggleEstado(${id}, '${nombre}', 'activo')">
                    <i class="bi bi-person-dash-fill"></i> Desactivar
                </button>`;
    }
    return `<button class="btn btn-sm btn-success btn-accion" onclick="toggleEstado(${id}, '${nombre}', 'inactivo')">
                <i class="bi bi-person-check-fill"></i> Activar
            </button>`;
}

function cargarCatalogos(callback) {
    $.get(API_BASE + '/catalogos', function (res) {
        if (!res.success) return;
        $('#cargo_id').find('option:not(:first)').remove();
        $('#proyecto_id').find('option:not(:first)').remove();
        res.cargos.forEach(c => $('#cargo_id').append(`<option value="${c.id}">${c.nombre}</option>`));
        res.proyectos.forEach(p => $('#proyecto_id').append(`<option value="${p.id}">${p.nombre}</option>`));
        if (callback) callback();
    });
}

function cargarTrabajadores() {
    $.get(API_BASE, function (res) {
        const tbody = $('#tbodyTrabajadores').empty();

        if (!res.success || res.data.length === 0) {
            tbody.append('<tr><td colspan="7" class="text-center text-muted py-4">No hay trabajadores registrados.</td></tr>');
            return;
        }

        res.data.forEach((t, i) => {
            tbody.append(`
                <tr>
                    <td>${i + 1}</td>
                    <td>${t.nombre_completo}</td>
                    <td>${t.dni}</td>
                    <td>${t.cargo ?? '—'}</td>
                    <td>${t.proyecto ?? '—'}</td>
                    <td>${estadoBadge(t.estado)}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info btn-accion text-white" onclick="verDetalle(${t.id})">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-warning btn-accion" onclick="editarTrabajador(${t.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        ${botonEstado(t.id, t.nombre_completo, t.estado)}
                    </td>
                </tr>
            `);
        });
    }).fail(() => {
        $('#tbodyTrabajadores').html('<tr><td colspan="7" class="text-center text-danger">Error al cargar datos.</td></tr>');
        Notiflix.Notify.failure('No se pudieron cargar los trabajadores.');
    });
}

function verDetalle(id) {
    $('#detalleContenido').html('<div class="text-center py-3"><div class="spinner-border text-info"></div></div>');
    new bootstrap.Modal('#modalDetalle').show();

    $.get(`${API_BASE}/${id}`, function (res) {
        if (!res.success) {
            $('#detalleContenido').html('<p class="text-danger">No se pudo cargar el detalle.</p>');
            return;
        }
        const t = res.data;
        $('#detalleContenido').html(`
            <table class="table table-sm table-bordered mb-0">
                <tr><th class="bg-light" width="40%">Nombre completo</th><td>${t.nombre} ${t.apellido}</td></tr>
                <tr><th class="bg-light">DNI</th><td>${t.dni}</td></tr>
                <tr><th class="bg-light">Email</th><td>${t.email}</td></tr>
                <tr><th class="bg-light">Teléfono</th><td>${t.telefono ?? '—'}</td></tr>
                <tr><th class="bg-light">Cargo</th><td>${t.cargo ?? '—'}</td></tr>
                <tr><th class="bg-light">Proyecto</th><td>${t.proyecto ?? '—'}</td></tr>
                <tr><th class="bg-light">Fecha de ingreso</th><td>${t.fecha_ingreso ?? '—'}</td></tr>
                <tr><th class="bg-light">Estado</th><td>${estadoBadge(t.estado)}</td></tr>
            </table>
        `);
    }).fail(() => Notiflix.Notify.failure('Error al cargar el detalle.'));
}

function editarTrabajador(id) {
    cargarCatalogos(() => {
        $.get(`${API_BASE}/${id}`, function (res) {
            if (!res.success) { Notiflix.Notify.failure('No se pudo cargar el trabajador.'); return; }
            const t = res.data;
            $('#trabajadorId').val(t.id);
            $('#nombre').val(t.nombre);
            $('#apellido').val(t.apellido);
            $('#dni').val(t.dni);
            $('#email').val(t.email);
            $('#telefono').val(t.telefono);
            $('#fecha_ingreso').val(t.fecha_ingreso);
            $('#cargo_id').val(t.cargo_id);
            $('#proyecto_id').val(t.proyecto_id);
            $('#estado').val(t.estado);
            $('#formTrabajador').removeClass('was-validated');
            $('#formErrors').addClass('d-none').empty();
            $('#modalFormLabel').html('<i class="bi bi-pencil-fill me-2"></i>Editar Trabajador');
            new bootstrap.Modal('#modalForm').show();
        }).fail(() => Notiflix.Notify.failure('Error al cargar el trabajador.'));
    });
}

function guardarTrabajador(e) {
    e.preventDefault();
    $('#formErrors').addClass('d-none').empty();

    const form = document.getElementById('formTrabajador');
    if (!form.checkValidity()) { form.classList.add('was-validated'); return; }

    const id  = $('#trabajadorId').val();
    const url = id ? `${API_BASE}/${id}` : API_BASE;

    Notiflix.Loading.hourglass('Guardando...');

    $.ajax({
        url,
        method: id ? 'PUT' : 'POST',
        contentType: 'application/json',
        headers: { 'X-CSRF-TOKEN': CSRF() },
        data: JSON.stringify({
            nombre:        $('#nombre').val().trim(),
            apellido:      $('#apellido').val().trim(),
            dni:           $('#dni').val().trim(),
            email:         $('#email').val().trim(),
            telefono:      $('#telefono').val().trim(),
            fecha_ingreso: $('#fecha_ingreso').val(),
            cargo_id:      $('#cargo_id').val(),
            proyecto_id:   $('#proyecto_id').val(),
            estado:        $('#estado').val(),
        }),
        success(res) {
            Notiflix.Loading.remove();
            bootstrap.Modal.getInstance('#modalForm')?.hide();
            Notiflix.Notify.success(res.message);
            cargarTrabajadores();
        },
        error(xhr) {
            Notiflix.Loading.remove();
            const res = xhr.responseJSON;
            if (res?.errors) {
                $('#formErrors').removeClass('d-none').html(Object.values(res.errors).flat().join('<br>'));
            } else {
                Notiflix.Notify.failure('Error al guardar. Intente nuevamente.');
            }
        },
    });
}

function toggleEstado(id, nombre, estadoActual) {
    const activando = estadoActual === 'inactivo';
    const color     = activando ? '#198754' : '#dc3545';

    Notiflix.Confirm.show(
        activando ? 'Activar trabajador' : 'Desactivar trabajador',
        activando ? `¿Desea activar a ${nombre}?` : `¿Desea desactivar a ${nombre}?`,
        activando ? 'Sí, activar' : 'Sí, desactivar',
        'Cancelar',
        function () {
            Notiflix.Loading.hourglass(activando ? 'Activando...' : 'Desactivando...');
            $.ajax({
                url: `${API_BASE}/${id}`,
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF() },
                success(res) {
                    Notiflix.Loading.remove();
                    Notiflix.Notify.success(res.message);
                    cargarTrabajadores();
                },
                error() {
                    Notiflix.Loading.remove();
                    Notiflix.Notify.failure('Error al cambiar el estado del trabajador.');
                },
            });
        },
        null,
        { titleColor: color, okButtonBackground: color, cancelButtonBackground: '#6c757d' }
    );
}

$(document).ready(function () {
    cargarTrabajadores();

    $('#btnNuevo').on('click', function () {
        $('#trabajadorId').val('');
        $('#formTrabajador')[0].reset();
        $('#formTrabajador').removeClass('was-validated');
        $('#formErrors').addClass('d-none').empty();
        $('#modalFormLabel').html('<i class="bi bi-person-plus-fill me-2"></i>Nuevo Trabajador');
        cargarCatalogos(() => new bootstrap.Modal('#modalForm').show());
    });

    $('#formTrabajador').on('submit', guardarTrabajador);
});
