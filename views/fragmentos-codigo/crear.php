<?php include 'views/templates/header.php'; ?>
<?php include 'views/templates/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Fragmento de Código</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="index.php?controller=fragmentos-codigo&action=listar">Fragmentos</a></li>
                        <li class="breadcrumb-item active">Nuevo Fragmento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Crear Nuevo Fragmento de Código</h3>
                        </div>
                        <form action="index.php?controller=fragmentos-codigo&action=crear" method="POST">
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
                                                   value="<?= $_POST['titulo'] ?? '' ?>" required 
                                                   placeholder="Ej: Función para validar email en PHP">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categoria">Categoría *</label>
                                            <select class="form-control" id="categoria" name="categoria" required>
                                                <option value="">Seleccionar categoría</option>
                                                <option value="Funciones" <?= ($_POST['categoria'] ?? '') == 'Funciones' ? 'selected' : '' ?>>Funciones</option>
                                                <option value="Clases" <?= ($_POST['categoria'] ?? '') == 'Clases' ? 'selected' : '' ?>>Clases</option>
                                                <option value="Consultas" <?= ($_POST['categoria'] ?? '') == 'Consultas' ? 'selected' : '' ?>>Consultas SQL</option>
                                                <option value="Utilidades" <?= ($_POST['categoria'] ?? '') == 'Utilidades' ? 'selected' : '' ?>>Utilidades</option>
                                                <option value="WordPress" <?= ($_POST['categoria'] ?? '') == 'WordPress' ? 'selected' : '' ?>>WordPress</option>
                                                <option value="JavaScript" <?= ($_POST['categoria'] ?? '') == 'JavaScript' ? 'selected' : '' ?>>JavaScript</option>
                                                <option value="CSS" <?= ($_POST['categoria'] ?? '') == 'CSS' ? 'selected' : '' ?>>CSS</option>
                                                <option value="HTML" <?= ($_POST['categoria'] ?? '') == 'HTML' ? 'selected' : '' ?>>HTML</option>
                                                <option value="Otros" <?= ($_POST['categoria'] ?? '') == 'Otros' ? 'selected' : '' ?>>Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lenguaje">Lenguaje de Programación *</label>
                                            <select class="form-control" id="lenguaje" name="lenguaje" required>
                                                <option value="PHP" <?= ($_POST['lenguaje'] ?? '') == 'PHP' ? 'selected' : '' ?>>PHP</option>
                                                <option value="JavaScript" <?= ($_POST['lenguaje'] ?? '') == 'JavaScript' ? 'selected' : '' ?>>JavaScript</option>
                                                <option value="HTML" <?= ($_POST['lenguaje'] ?? '') == 'HTML' ? 'selected' : '' ?>>HTML</option>
                                                <option value="CSS" <?= ($_POST['lenguaje'] ?? '') == 'CSS' ? 'selected' : '' ?>>CSS</option>
                                                <option value="SQL" <?= ($_POST['lenguaje'] ?? '') == 'SQL' ? 'selected' : '' ?>>SQL</option>
                                                <option value="Python" <?= ($_POST['lenguaje'] ?? '') == 'Python' ? 'selected' : '' ?>>Python</option>
                                                <option value="Java" <?= ($_POST['lenguaje'] ?? '') == 'Java' ? 'selected' : '' ?>>Java</option>
                                                <option value="Otro" <?= ($_POST['lenguaje'] ?? '') == 'Otro' ? 'selected' : '' ?>>Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tags">Tags (separados por comas)</label>
                                            <input type="text" class="form-control" id="tags" name="tags" 
                                                   value="<?= $_POST['tags'] ?? '' ?>" 
                                                   placeholder="Ej: php, función, validación, email">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" 
                                              rows="3" placeholder="Describe para qué sirve este fragmento de código y cómo usarlo..."><?= $_POST['descripcion'] ?? '' ?></textarea>
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
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <textarea class="form-control" id="codigo" name="codigo" 
                                                      rows="15" placeholder="Escribe o pega tu código aquí..." 
                                                      style="font-family: 'Courier New', monospace; font-size: 14px;" 
                                                      required><?= $_POST['codigo'] ?? '' ?></textarea>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> 
                                                Soporta sintaxis highlight para mejor visualización
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Fragmento
                                </button>
                                <button type="button" class="btn btn-success btn-copiar-codigo">
                                    <i class="fas fa-copy"></i> Copiar Código
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo"></i> Limpiar
                                </button>
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
    const btnCopiar = document.querySelector('.btn-copiar-codigo');

    // Formatear código (sencillo)
    if (btnFormatear) {
        btnFormatear.addEventListener('click', function() {
            const codigo = codigoTextarea.value;
            // Simple formatting - add proper indentation
            const lines = codigo.split('\n');
            let indentLevel = 0;
            const formattedLines = lines.map(line => {
                const trimmedLine = line.trim();
                if (trimmedLine.endsWith('}') || trimmedLine.endsWith(');')) {
                    indentLevel = Math.max(0, indentLevel - 1);
                }
                
                const indentedLine = '    '.repeat(indentLevel) + trimmedLine;
                
                if (trimmedLine.endsWith('{') || trimmedLine.includes(' function') || trimmedLine.includes(' class ')) {
                    indentLevel++;
                }
                
                return indentedLine;
            });
            
            codigoTextarea.value = formattedLines.join('\n');
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

    // Copiar código
    if (btnCopiar) {
        btnCopiar.addEventListener('click', function() {
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
        });
    }

    // Auto-resize textarea
    codigoTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Trigger initial resize
    codigoTextarea.style.height = (codigoTextarea.scrollHeight) + 'px';
});
</script>

<?php include 'views/templates/footer.php'; ?>