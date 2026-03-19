<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Módulo de Trabajadores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/trabajadores.css') }}">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">
            <i class="bi bi-people-fill me-2"></i>Módulo de Trabajadores
        </span>
    </div>
</nav>

<div class="container">

    <!-- Tabla principal -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-table me-2"></i>Lista de Trabajadores</h5>
            <button class="btn btn-light btn-sm fw-semibold" id="btnNuevo">
                <i class="bi bi-plus-lg me-1"></i>Nuevo Trabajador
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Cargo</th>
                            <th>Proyecto</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyTrabajadores">
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                                Cargando datos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- MODAL REGISTRAR / EDITAR -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFormLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Nuevo Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTrabajador" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="trabajadorId">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" maxlength="100" required>
                            <div class="invalid-feedback">El nombre es obligatorio.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido" maxlength="100" required>
                            <div class="invalid-feedback">El apellido es obligatorio.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">DNI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dni" maxlength="20" required>
                            <div class="invalid-feedback">El DNI es obligatorio.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" maxlength="150" required>
                            <div class="invalid-feedback">Ingrese un email válido.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de Ingreso <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_ingreso" required>
                            <div class="invalid-feedback">La fecha es obligatoria.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cargo <span class="text-danger">*</span></label>
                            <select class="form-select" id="cargo_id" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                            <div class="invalid-feedback">Seleccione un cargo.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select" id="proyecto_id" required>
                                <option value="">-- Seleccione --</option>
                            </select>
                            <div class="invalid-feedback">Seleccione un proyecto.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado</label>
                            <select class="form-select" id="estado">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETALLE -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-lines-fill me-2"></i>Detalle del Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleContenido">
                <div class="text-center py-3">
                    <div class="spinner-border text-info"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/notiflix-aio.min.js') }}"></script>
<script>
    window.API_BASE = '{{ url("/api/trabajadores") }}';
</script>
<script src="{{ asset('js/trabajadores.js') }}"></script>

</body>
</html>
