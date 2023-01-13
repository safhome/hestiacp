<!-- Begin toolbar -->
<div class="toolbar">
	<div class="toolbar-inner">
		<div class="toolbar-buttons">
			<?php if ($_SESSION["userContext"] === "admin" && isset($_GET["user"]) && htmlentities($_GET["user"]) !== "admin") { ?>
				<a href="/list/log/?user=<?= htmlentities($_GET["user"]) ?>&token=<?= $_SESSION["token"] ?>" class="button button-secondary" id="btn-back"><i class="fas fa-arrow-left icon-blue"></i><?= _("Back") ?></a>
			<?php } else { ?>
				<a href="/list/log/" class="button button-secondary" id="btn-back"><i class="fas fa-arrow-left icon-blue"></i><?= _("Back") ?></a>
			<?php } ?>
		</div>
		<div class="toolbar-buttons">
			<a href="javascript:location.reload();" class="button button-secondary"><i class="fas fa-arrow-rotate-right icon-green"></i><?= _("Refresh") ?></a>
			<?php if ($_SESSION["userContext"] === "admin" && $_SESSION["look"] === "admin" && $_SESSION["POLICY_SYSTEM_PROTECTED_ADMIN"] === "yes") { ?>
				<!-- Hide delete buttons-->
			<?php } else { ?>
				<?php if ($_SESSION["userContext"] === "admin" || ($_SESSION["userContext"] === "user" && $_SESSION["POLICY_USER_DELETE_LOGS"] !== "no")) { ?>
					<div class="actions-panel" key-action="js">
						<a class="data-controls do_delete button button-secondary button-danger">
							<i class="do_delete fas fa-circle-xmark icon-red"></i><?= _("Delete") ?>
							<?php if ($_SESSION["userContext"] === "admin" && isset($_GET["user"])) { ?>
								<input type="hidden" name="delete_url" value="/delete/log/auth/?user=<?= htmlentities($_GET["user"]) ?>&token=<?= $_SESSION["token"] ?>">
							<?php } else { ?>
								<input type="hidden" name="delete_url" value="/delete/log/auth/?token=<?= $_SESSION["token"] ?>">
							<?php } ?>
							<div class="dialog js-confirm-dialog-delete" title="<?= _("Confirmation") ?>">
								<p><?= _("DELETE_LOGS_CONFIRMATION") ?></p>
							</div>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End toolbar -->

<div class="container units">
	<div class="header table-header">
		<div class="l-unit__col l-unit__col--right">
			<div class="clearfix l-unit__stat-col--left u-text-center">
				<b><?= _("Status") ?></b>
			</div>
			<div class="clearfix l-unit__stat-col--left"><b><?= _("Date") ?></b></div>
			<div class="clearfix l-unit__stat-col--left compact-2"><b><?= _("Time") ?></b></div>
			<div class="clearfix l-unit__stat-col--left"><b><?= _("IP address") ?></b></div>
			<div class="clearfix l-unit__stat-col--left wide-7"><b><?= _("Browser") ?></b></div>
		</div>
	</div>

	<!-- Begin log history entry loop -->
	<?php
		foreach ($data as $key => $value) {
			++$i;

			if ($data[$key]['ACTION'] == 'login') {
				if ($data[$key]['ACTIVE'] === 'yes') {
					$action_icon = 'fa-right-to-bracket icon-maroon';
				} else {
					$action_icon = ' fa-right-to-bracket icon-dim';
				}
			}
			if ($data[$key]['STATUS'] == 'success')	{
					$status_icon = 'fa-circle-check icon-green';
					$status_title = 'Success';
			} else {
					$status_icon = 'fa-circle-minus icon-red';
					$status_title = 'Failed';
			}
		?>
		<div class="l-unit header animate__animated animate__fadeIn">
			<div class="l-unit__col l-unit__col--right">
				<div class="clearfix l-unit__stat-col--left u-text-center">
					<i class="fas <?=$status_icon;?> u-mr5" title="<?=$status_title;?>"></i>
				</div>
				<div class="clearfix l-unit__stat-col--left"><b><?=translate_date($data[$key]['DATE'])?></b></div>
				<div class="clearfix l-unit__stat-col--left compact-2"><b><?=htmlspecialchars($data[$key]['TIME']);?></b></div>
				<div class="clearfix l-unit__stat-col--left"><?=htmlspecialchars($data[$key]['IP']);?></div>
				<div class="clearfix l-unit__stat-col--left wide-7"><?=htmlspecialchars($data[$key]['USER_AGENT']);?></b></div>
			</div>
		</div>
	<?php } ?>

</div>

<footer class="app-footer">
	<div class="container app-footer-inner">
		<p>
			<?php printf(ngettext("%d log record", "%d log records", $i), $i); ?>
		</p>
	</div>
</footer>
