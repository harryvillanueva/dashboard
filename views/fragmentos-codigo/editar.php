<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Fragmento de Código</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=fragmentos-codigo&action=listar">Fragmentos</a></li>
                        <li class="breadcrumb-item active">Editar Fragmento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Editando: <?= htmlspecialchars($fragmento['titulo']) ?></h3>
                        </div>
                        <form action="index.php?controller=fragmentos-codigo&action=editar&id=<?= $fragmento['id'] ?>" method="POST">
                            <div class="card-body">
                                <?php if (!empty($mensaje)): 
                                    $tipo = explode(':', $mensaje)[0];
                                    $texto = explode(':', $mensaje)[1];
                                ?>
                                    <div class="alert alert-<?= $tipo == 'success' ? 'success' : 'danger' ?>">
                                        <?= htmlspecialchars($texto) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="titulo">Título del Fragmento *</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo" 
                                                   value="<?= $_POST['titulo'] ?? $fragmento['titulo'] ?>" required 
                                                   placeholder="Ej: Función para validar email en PHP">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categoria">Categoría *</label>
                                            <select class="form-control" id="categoria" name="categoria" required>
                                                <option value="">Seleccionar categoría</option>
                                                <option value="Funciones" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'Funciones' ? 'selected' : '' ?>>Funciones</option>
                                                <option value="Clases" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'Clases' ? 'selected' : '' ?>>Clases</option>
                                                <option value="Consultas" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'Consultas' ? 'selected' : '' ?>>Consultas SQL</option>
                                                <option value="Utilidades" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'Utilidades' ? 'selected' : '' ?>>Utilidades</option>
                                                <option value="WordPress" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'WordPress' ? 'selected' : '' ?>>WordPress</option>
                                                <option value="JavaScript" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'JavaScript' ? 'selected' : '' ?>>JavaScript</option>
                                                <option value="CSS" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'CSS' ? 'selected' : '' ?>>CSS</option>
                                                <option value="HTML" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'HTML' ? 'selected' : '' ?>>HTML</option>
                                                <option value="Otros" <?= ($_POST['categoria'] ?? $fragmento['categoria']) == 'Otros' ? 'selected' : '' ?>>Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lenguaje">Lenguaje de Programación *</label>
                                            <select class="form-control" id="lenguaje" name="lenguaje" required>
                                                <option value="PHP" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'PHP' ? 'selected' : '' ?>>PHP</option>
                                                <option value="JavaScript" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'JavaScript' ? 'selected' : '' ?>>JavaScript</option>
                                                <option value="HTML" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'HTML' ? 'selected' : '' ?>>HTML</option>
                                                <option value="CSS" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'CSS' ? 'selected' : '' ?>>CSS</option>
                                                <option value="SQL" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'SQL' ? 'selected' : '' ?>>SQL</option>
                                                <option value="Python" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'Python' ? 'selected' : '' ?>>Python</option>
                                                <option value="Java" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'Java' ? 'selected' : '' ?>>Java</option>
                                                <option value="Otro" <?= ($_POST['lenguaje'] ?? $fragmento['lenguaje']) == 'Otro' ? 'selected' : '' ?>>Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tags">Tags (separados por comas)</label>
                                            <input type="text" class="form-control" id="tags" name="tags" 
                                                   value="<?= $_POST['tags'] ?? $fragmento['tags'] ?>" 
                                                   placeholder="Ej: php, función, validación, email">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" 
                                              rows="3" placeholder="Describe para qué sirve este fragmento de código y cómo usarlo..."><?= $_POST['descripcion'] ?? $fragmento['descripcion'] ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="codigo">Código *</label>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool btn-formatear" title="Formatear código">
                                                    <i class="fas fa-indent"></i> Formatear
                                                </button>
                                                <button type="button" class="btn btn-tool btn-limpiar" title="Limpiar código">
                                                    <i class="fas fa-broom"></i> Limpiar
                                                </button>
                                                <button type="button" class="btn btn-tool btn-copiar-codigo" title="Copiar código">
                                                    <i class="fas fa-copy"></i> Copiar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <textarea class="form-control" id="codigo" name="codigo" 
                                                      rows="15" placeholder="Escribe o pega tu código aquí..." 
                                                      style="font-family: 'Courier New', monospace; font-size: 14px;" 
                                                      required><?= $_POST['codigo'] ?? $fragmento['codigo'] ?></textarea>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> 
                                                Última modificación: <?= date('d/m/Y H:i', strtotime($fragmento['fecha_modificacion'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información del fragmento -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Información del Fragmento</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Creado por:</strong> <?= htmlspecialchars($fragmento['usuario_nombre'] ?? 'Sistema') ?>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Fecha creación:</strong> <?= date('d/m/Y H:i', strtotime($fragmento['fecha_creacion'])) ?>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Última modificación:</strong> <?= date('d/m/Y H:i', strtotime($fragmento['fecha_modificacion'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Fragmento
                                </button>
                                <button type="button" class="btn btn-success btn-copiar-codigo-footer">
                                    <i class="fas fa-copy"></i> Copiar Código
                                </button>
                                <a href="index.php?controller=fragmentos-codigo&action=ver&id=<?= $fragmento['id'] ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Ver Fragmento
                                </a>
                                <a href="index.php?controller=fragmentos-codigo&action=listar" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoTextarea = document.getElementById('codigo');
    const btnFormatear = document.querySelector('.btn-formatear');
    const btnLimpiar = document.querySelector('.btn-limpiar');
    const btnCopiarHeader = document.querySelector('.btn-copiar-codigo');
    const btnCopiarFooter = document.querySelector('.btn-copiar-codigo-footer');

    // Función para formatear código PHP
    function formatearCodigoPHP(codigo) {
        const lines = codigo.split('\n');
        let indentLevel = 0;
        const formattedLines = [];
        
        for (let line of lines) {
            const trimmedLine = line.trim();
            
            // Reducir indentación antes de líneas que cierran bloques
            if (trimmedLine.endsWith('}') || trimmedLine.endsWith(');') || trimmedLine === '}') {
                indentLevel = Math.max(0, indentLevel - 1);
            }
            
            // Aplicar indentación actual
            const indentedLine = '    '.repeat(indentLevel) + trimmedLine;
            formattedLines.push(indentedLine);
            
            // Aumentar indentación después de líneas que abren bloques
            if (trimmedLine.endsWith('{') || 
                trimmedLine.startsWith('if ') || 
                trimmedLine.startsWith('foreach ') || 
                trimmedLine.startsWith('for ') || 
                trimmedLine.startsWith('while ') || 
                trimmedLine.startsWith('function ') || 
                trimmedLine.startsWith('class ') ||
                trimmedLine.includes(' function')) {
                indentLevel++;
            }
        }
        
        return formattedLines.join('\n');
    }

    // Función para formatear código JavaScript
    function formatearCodigoJS(codigo) {
        return formatearCodigoPHP(codigo); // Similar a PHP para estructuras básicas
    }

    // Función para formatear código HTML
    function formatearCodigoHTML(codigo) {
        const lines = codigo.split('\n');
        let indentLevel = 0;
        const formattedLines = [];
        
        for (let line of lines) {
            const trimmedLine = line.trim();
            
            // Reducir indentación para etiquetas de cierre
            if (trimmedLine.startsWith('</')) {
                indentLevel = Math.max(0, indentLevel - 1);
            }
            
            // Aplicar indentación actual
            const indentedLine = '    '.repeat(indentLevel) + trimmedLine;
            formattedLines.push(indentedLine);
            
            // Aumentar indentación para etiquetas de apertura (que no sean self-closing)
            if (trimmedLine.startsWith('<') && 
                !trimmedLine.startsWith('</') && 
                !trimmedLine.endsWith('/>') &&
                !trimmedLine.includes('<img') &&
                !trimmedLine.includes('<br') &&
                !trimmedLine.includes('<input') &&
                !trimmedLine.includes('<meta') &&
                !trimmedLine.includes('<link')) {
                indentLevel++;
            }
        }
        
        return formattedLines.join('\n');
    }

    // Formatear código según el lenguaje
    if (btnFormatear) {
        btnFormatear.addEventListener('click', function() {
            const lenguaje = document.getElementById('lenguaje').value;
            const codigo = codigoTextarea.value;
            let codigoFormateado = codigo;

            switch(lenguaje.toLowerCase()) {
                case 'php':
                    codigoFormateado = formatearCodigoPHP(codigo);
                    break;
                case 'javascript':
                    codigoFormateado = formatearCodigoJS(codigo);
                    break;
                case 'html':
                    codigoFormateado = formatearCodigoHTML(codigo);
                    break;
                case 'css':
                    // Para CSS, simplemente limpiamos el formato existente
                    codigoFormateado = codigo.split('}').map(part => {
                        return part.split('{').map(p => p.trim()).join(' {\n    ') + '\n}';
                    }).join('\n\n').replace(/\n\}/g, '\n}');
                    break;
                default:
                    // Para otros lenguajes, uso formato básico
                    codigoFormateado = formatearCodigoPHP(codigo);
            }
            
            codigoTextarea.value = codigoFormateado;
            
            // Mostrar notificación
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Éxito!</strong> Código formateado para ${lenguaje}.
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 2000);
        });
    }

    // Limpiar código
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres limpiar todo el código?')) {
                codigoTextarea.value = '';
            }
        });
    }

    // Función para copiar código
    function copiarCodigo() {
        const codigo = codigoTextarea.value;
        if (codigo.trim() === '') {
            alert('No hay código para copiar');
            return;
        }
        
        navigator.clipboard.writeText(codigo).then(function() {
            // Mostrar notificación
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Éxito!</strong> Código copiado al portapapeles.
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }).catch(function(err) {
            console.error('Error al copiar: ', err);
            alert('Error al copiar al portapapeles');
        });
    }

    // Botón copiar en el header
    if (btnCopiarHeader) {
        btnCopiarHeader.addEventListener('click', copiarCodigo);
    }

    // Botón copiar en el footer
    if (btnCopiarFooter) {
        btnCopiarFooter.addEventListener('click', copiarCodigo);
    }

    // Auto-resize textarea
    codigoTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Trigger initial resize
    codigoTextarea.style.height = (codigoTextarea.scrollHeight) + 'px';

    // Detectar cambios en el código para mostrar indicador de modificación
    let codigoOriginal = codigoTextarea.value;
    codigoTextarea.addEventListener('input', function() {
        const hasChanges = this.value !== codigoOriginal;
        const submitBtn = document.querySelector('button[type="submit"]');
        
        if (hasChanges) {
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Actualizar Fragmento *';
            submitBtn.classList.remove('btn-warning');
            submitBtn.classList.add('btn-danger');
        } else {
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Actualizar Fragmento';
            submitBtn.classList.remove('btn-danger');
            submitBtn.classList.add('btn-warning');
        }
    });
});
</script>

<?php include 'views/templates/footer.php'; ?>