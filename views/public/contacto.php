<?php
include '././backend/object/Message.php';
?>

<div class="container is-fluid">
    <h1 class="title">Contacto</h1>

    <?php if (!empty($errors)): ?>
        <div class="notification is-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif (!empty($success)): ?>
        <div class="notification is-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" placeholder="Text input" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Teléfono</label>
            <div class="control has-icons-left">
                <input class="input" type="text" name="phone" placeholder="Número de teléfono" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                <span class="icon is-small is-left">
                    <i class="fas fa-phone"></i>
                </span>
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="email" name="email" placeholder="Email input" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>

        <div class="field">
            <label class="label">Inmobiliaria</label>
            <div class="control">
                <div class="select">
                    <select name="inmobiliaria">
                        <option value="">Selecciona una inmobiliaria</option>
                        <?php foreach ($inmobiliarias as $inmobiliaria): ?>
                            <option value="<?php echo htmlspecialchars($inmobiliaria['id_agency']); ?>"
                                <?php echo (isset($_POST['inmobiliaria']) && $_POST['inmobiliaria'] == $inmobiliaria['id_agency']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($inmobiliaria['name_agency']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">Opciones</label>
            <div class="control">
                <div class="select">
                    <select name="subject">
                        <option value="">Selecciona un tema</option>
                        <option value="Consultar" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Consultar') ? 'selected' : ''; ?>>Consulta</option>
                        <option value="Visitar" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Visitar') ? 'selected' : ''; ?>>Agendar Visita</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">Mensaje</label>
            <div class="control">
                <textarea class="textarea" name="message" placeholder="Escribe tu mensaje aquí..."><?php echo htmlspecialchars($_POST['message'] ?? 'Buenos días, me gustaría obtener más información sobre una de las propiedades. ¡Muchas gracias!'); ?></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link">Enviar</button>
            </div>
        </div>
    </form>
</div>