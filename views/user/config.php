<div class='main'>

    <section>
        <div class='content'>
            <form class="config" id="config_form" action='javascript:updateConfig();' method='post'>

                <p>Nome de Utilizador</p>
                <input  type='text' name='user' value='<?php echo $_SESSION['user_user']; ?>' readonly>

                <p>Cor do Perfil</p>
                <input type="radio" name="color" <!-- BEGIN COLOR_BLUE -->checked="checked"<!-- END COLOR_BLUE --> value="1">Azul<br>

                <input type="radio" name="color" <!-- BEGIN COLOR_ORANGE -->checked="checked"<!-- END COLOR_ORANGE --> value="4">Cor de Laranja<br>

                <input type="radio" name="color" <!-- BEGIN COLOR_GREEN -->checked="checked"<!-- END COLOR_GREEN --> value="2">Verde<br>

                <input type="radio" name="color" <!-- BEGIN COLOR_RED -->checked="checked"<!-- END COLOR_RED --> value="3">Vermelho

                <p>Sobre mim</p>
                <textarea name="bio">{CFG_BIO}</textarea>

                <input class='submit' type='submit'>

            </form>

        </div>
    </section>

</div>