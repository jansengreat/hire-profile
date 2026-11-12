<?php
/**
 * Footer situs + dialog perkenalan.
 *
 * @package Hire_Profile
 */
$hp_name = hp_get( 'full_name' );
?>
<footer class="hp-footer">
	<div class="hp-wrap hp-footer__inner">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) . ' ' . $hp_name ); ?></p>
		<?php if ( hp_get( 'footer_note' ) ) : ?>
			<p class="hp-footer__note"><?php echo esc_html( hp_get( 'footer_note' ) ); ?></p>
		<?php endif; ?>
	</div>
</footer>

<?php if ( hp_get( 'dialog' ) ) :
	$hp_links  = hp_links();
	$hp_skills = array_slice( hp_all_skills(), 0, 6 );
	?>
	<button type="button" class="hp-fab" data-hp-open aria-haspopup="dialog">
		<?php echo hp_photo( 'hp-fab__photo', 32 ); // phpcs:ignore ?>
		<span><?php echo esc_html( hp_t( 'hire' ) ); ?></span>
	</button>
	<dialog class="hp-dialog" id="hp-dialog" aria-labelledby="hp-dialog-title">
		<div class="hp-dialog__body">
			<button type="button" class="hp-dialog__close" data-hp-close aria-label="<?php echo esc_attr( hp_t( 'close' ) ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M5 5l10 10M15 5L5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
			</button>
			<div class="hp-dialog__head">
				<?php echo hp_photo( 'hp-dialog__photo', 72 ); // phpcs:ignore ?>
				<div>
					<?php echo hp_status(); // phpcs:ignore ?>
					<h2 id="hp-dialog-title"><?php echo esc_html( sprintf( hp_t( 'hi' ), $hp_name ) ); ?></h2>
				</div>
			</div>
			<p class="hp-dialog__headline"><?php echo esc_html( hp_get( 'headline' ) ); ?></p>
			<?php if ( hp_get( 'pitch' ) ) : ?>
				<p><?php echo esc_html( wp_trim_words( hp_get( 'pitch' ), 34, '…' ) ); ?></p>
			<?php endif; ?>
			<dl class="hp-dialog__facts">
				<?php if ( hp_get( 'years' ) ) : ?>
					<div><dt><?php echo esc_html( hp_t( 'experience_lbl' ) ); ?></dt><dd><?php echo esc_html( sprintf( hp_t( 'years' ), hp_get( 'years' ) ) ); ?></dd></div>
				<?php endif; ?>
				<?php if ( hp_get( 'timezone' ) ) : ?>
					<div><dt><?php echo esc_html( hp_t( 'timezone' ) ); ?></dt><dd><?php echo esc_html( hp_get( 'timezone' ) ); ?></dd></div>
				<?php endif; ?>
			</dl>
			<?php if ( $hp_skills ) : ?>
				<ul class="hp-chips" aria-label="<?php echo esc_attr( hp_t( 'skills' ) ); ?>">
					<?php foreach ( $hp_skills as $s ) : ?><li><?php echo esc_html( $s ); ?></li><?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div class="hp-actions">
				<a class="hp-btn hp-btn--primary" href="<?php echo esc_url( hp_primary_href() ); ?>" data-hp-dismiss><?php echo esc_html( hp_t( 'start' ) ); ?></a>
				<?php if ( isset( $hp_links['whatsapp'] ) ) : ?>
					<a class="hp-btn" href="<?php echo esc_url( $hp_links['whatsapp'][1] ); ?>" target="_blank" rel="noopener">WhatsApp</a>
				<?php endif; ?>
				<?php if ( hp_get( 'cv' ) ) : ?>
					<a class="hp-btn" href="<?php echo esc_url( hp_get( 'cv' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( hp_t( 'cv' ) ); ?></a>
				<?php endif; ?>
			</div>
			<?php if ( ! is_front_page() ) : ?>
				<p class="hp-dialog__more"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( hp_t( 'see_profile' ) ); ?></a></p>
			<?php endif; ?>
		</div>
	</dialog>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
