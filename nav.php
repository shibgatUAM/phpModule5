<div style="border-bottom: 1px solid; border-color:#eee; padding-bottom: 30px; margin-bottom:30px;">
    <div class="float-left">
        <p>
            <a href="/index.php?task=report">All Employee</a>

			<?php if ( hasPrivilege() ): ?>
                |
                <a href="/index.php?task=add">Add New Employee</a>
			<?php endif; ?>

			<?php
			if ( isAdmin() ):
				?>
                |
                <a href="/index.php?task=seed">Seed</a>
			<?php
			endif;
			?>
        </p>
    </div>
    <div class="float-right">
		<?php
		if ( ! $_SESSION['loggedin'] ):
			?>
            <a href="auth.php">Log In</a>
		<?php
		else:
			?>
            <a href="auth.php?logout=true">Log Out (<?php echo $_SESSION['role'] ?>)</a>
		<?php
		endif;
		?>
    </div>
    <p></p>
</div>