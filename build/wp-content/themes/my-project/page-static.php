<?php
/**
 * Styleguide.
 *
 * @package MKDO_Theme
 */

?>

<div class="static-main">

	<?php
	get_header();

	// 1. Scans MKDO_THEME_PARTIALS_DIR for folders.
	// 2. Creates a view for each folder.
	// 3. Outputs all php files to that view.
	// 4. Applies flag classes to a parent div around each teplate part.
	foreach ( glob( MKDO_THEME_PARTIALS_DIR . '*', GLOB_ONLYDIR ) as $mkdo_theme_dir ) {
		$mkdo_theme_folders[] = basename( $mkdo_theme_dir );
	}
	?>

	<div class="static-wrap">

		<div class="static-header">

			<div class="static-heading__left">

				<h1 class="static-heading">Static Styleguide</h1>

				<div class="static-label">Updated: <?php echo esc_html( date( 'g:i:sa' ) ); ?></div>

			</div>

			<ul id="static-header__nav" class="static-header__nav">

				<li>
					<a href="" id="info">info</a>
				</li>

				<?php
				foreach ( $mkdo_theme_folders as $mkdo_theme_folder ) {
					echo '<li>';
						echo '<a href="" id="' . esc_html( $mkdo_theme_folder ) . '">' . esc_html( $mkdo_theme_folder ) . '</a>';
					echo '</li>';
				};
				?>

			</ul>

		</div>

	</div>

	<section class="static-page info">

		<div class="static-folder-header">

			<div class="static-wrap">

				<h2 class="static-heading">
					<svg x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><circle cx="251.5" cy="172" r="20"/><polygon points="272,344 272,216 224,216 224,224 240,224 240,344 224,344 224,352 288,352 288,344"/><path d="M256,48C141.1,48,48,141.1,48,256c0,114.9,93.1,208,208,208c114.9,0,208-93.1,208-208C464,141.1,370.9,48,256,48z M256,446.7c-105.1,0-190.7-85.5-190.7-190.7c0-105.1,85.5-190.7,190.7-190.7c105.1,0,190.7,85.5,190.7,190.7 C446.7,361.1,361.1,446.7,256,446.7z"/></svg>&nbsp; info
				</h2>

			</div>

		</div>

		<div id="info" class="static-wrap">

			<h3 class="static-heading">🎓 Managing Static &amp; Wired Markup</h3>

			<div class="static-text-content">
				<p>To keep our CSS and Markup organised, on this project we&#39;re maintaining a static styleguide. Each template-part in the styleguide will have a corresponding <code>.scss</code> file and <code>.php</code> file.</p>
				<p>When wiring up an element, any markup changes should be reflected inside the static version where possible. Any changes to scss should be checked against the elements in the styleguide that make use of those same styles.</p>
				<ul>
				<li><p>Static folder is located at:<br>
				<code>build/wp-content/themes/[THEME NAME]/template-parts/0static</code></p>
				</li>
				<li><p>Locally, you should be able to get to the generated styleguide via:<br>
				<a href="http://[THEME SLUG].test/static/">http://[THEME SLUG].test/static/</a></p>
				</li>
				</ul>
				<p><small>In some cases, an element may also have a corresponding <code>.js</code> file or function. For now, it&#39;s probably better to duplicate a function if you need to change and reuse it, since we don&#39;t currently account for this.</small></p>

				<h3 class="static-heading">🚩 Flags</h3>
				<p>Flags can be used to make things look correct in the styleguide, with styles that wont carry over to the main site.</p>
				<p>You can define a flag class inside:<br> <code>assets/scss/1_globals/static-styleguide/_flags.scss</code>.</p>
				<p>Classes added here can be passed into the <code>@flags</code> parameter in a static files php comment, minus the namespace "static-", and the styleguide will output that class on the <code>.static-part</code> that encloses the static element.</p>
				<p>For example: <code>@flags wrap</code> will add the <code>.static-wrap</code> class.</p>
			</div>

		</div>

	</section>

	<?php
	// Loop folders.
	foreach ( $mkdo_theme_folders as $mkdo_theme_folder ) {
		$mkdo_theme_glob = glob( MKDO_THEME_PARTIALS_DIR . $mkdo_theme_folder . '/*.php' );
		?>

		<section class="static-page <?php echo esc_attr( $mkdo_theme_folder ); ?>">

			<div class="static-folder-header">

				<div class="static-wrap">

					<h2 class="static-heading">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M456.3,160c-1.1,0-4.3,0-8.3,0v-41c0-13.3-9.4-23-22.8-23H230.9c-2.8,0-4.3-0.6-6.1-2.4l-22.5-22.5l-0.2-0.2 c-4.9-4.6-8.9-6.9-17.3-6.9H88.7C74.9,64,64,74.3,64,87v73c-4,0-7.1,0-8.3,0c-12.8,0-25.3,5.1-23.5,24.3C34,203.5,55.7,423,55.7,423 c2.7,17.8,11.7,25,25,25h352.5c12.7,0,21-7.8,23-25c0,0,22.2-212.9,23.6-233.5S470.9,160,456.3,160z M80,87c0-4.3,4.4-7,8.7-7h96.1 c3.5,0,3.7,0.2,6.2,2.5l22.5,22.4c4.8,4.8,10.4,7.1,17.4,7.1h194.3c4.5,0,6.8,2.6,6.8,7v41c-72,0-280,0-352,0V87z M440.2,423 c-0.8,4.7-3.7,9-8,9H82c-4.5,0-9.5-3.5-10.3-9l-24-239c0-4.4,3.6-8,8-8h400.6c4.4,0,8,3.6,8,8L440.2,423z"/></svg>&nbsp; <?php echo esc_html( $mkdo_theme_folder ); ?>
					</h2>

				</div>

			</div>

			<div class="static-wrap">

				<ul class="static-contents">

					<?php
					// Make contents links.
					foreach ( $mkdo_theme_glob as $mkdo_theme_file ) {
						$mkdo_theme_file_slug = pathinfo( $mkdo_theme_file )['filename'];
						$mkdo_theme_file_name = str_replace( '-', ' ', $mkdo_theme_file_slug );
						?>
						<li><a href="#<?php echo esc_html( $mkdo_theme_file_slug ); ?>"><?php echo esc_html( $mkdo_theme_file_name ); ?></a></li>
						<?php
					}  // End loop files.
					?>

				</ul>

			</div>

			<hr class="static-hr"/>

			<?php
			// Loop files.
			foreach ( $mkdo_theme_glob as $mkdo_theme_file ) {

				$mkdo_theme_file_slug    = pathinfo( $mkdo_theme_file )['filename'];
				$mkdo_theme_file_name    = str_replace( '-', ' ', $mkdo_theme_file_slug );
				$mkdo_theme_file_lines   = file( $mkdo_theme_file );
				$mkdo_theme_flag_classes = array( ' ' );
				$mkdo_theme_includes     = array();
				?>

				<div id="<?php echo esc_attr( $mkdo_theme_file_slug ); ?>" class="static-wrap">

					<h3 class="static-heading"><?php echo esc_html( $mkdo_theme_file_name ); ?></h3>

					<div class="static-info">

						<div class="static-info__row">

							<div class="static-info__col">

								<div class="static-label">File: </div><?php echo esc_html( $mkdo_theme_folder . '/' . $mkdo_theme_file_slug ); ?>
							</div>

							<?php

							// Loop lines in file.
							foreach ( $mkdo_theme_file_lines as $mkdo_theme_line_number => $mkdo_theme_line ) {
								// Search for @flags line.
								if ( strpos( $mkdo_theme_line, '@flags' ) !== false ) {

									// Array of flag values.
									$mkdo_theme_flagline = explode( ' ', $mkdo_theme_line );

									// Things to remove from the above.
									$mkdo_theme_removals = array( '', ' ', '*', '@flags' );
									$mkdo_theme_flags    = array_values( array_diff( $mkdo_theme_flagline, $mkdo_theme_removals ) );

									// Return flags.
									echo '<div class="static-info__col"><div class="static-label">Flags:</div>' . esc_html( implode( ', ', $mkdo_theme_flags ) ) . '</div>';

									// Prefix flags to make the classes.
									$mkdo_theme_flag_classes = $mkdo_theme_flags;
									foreach ( $mkdo_theme_flag_classes as &$mkdo_theme_value ) {
										$mkdo_theme_value = 'staticflag-' . $mkdo_theme_value;
									}
									unset( $mkdo_theme_value );
								}

								// Search for 'include' line.
								if ( strpos( $mkdo_theme_line, 'include' ) !== false ) {

									$mkdo_theme_regex   = '/\'.*\'/sUi';
									$mkdo_theme_include = preg_match( $mkdo_theme_regex, $mkdo_theme_line, $mkdo_theme_matches );

									if ( isset( $mkdo_theme_matches[0] ) ) {
										array_push( $mkdo_theme_includes, str_replace( '\'', '', $mkdo_theme_matches[0] ) );
									}
								}
							}

							// Return includes.
							if ( $mkdo_theme_includes ) {
								// Remove duplicates.
								$mkdo_theme_includes = array_unique( $mkdo_theme_includes );

								echo '<div class="static-info__col"><div class="static-label">Includes:</div>' . esc_html( implode( ', ', $mkdo_theme_includes ) ) . '</div>';
							}
							?>

						</div>

					</div>

				</div>

				<div class="static-part <?php echo esc_attr( implode( ' ', $mkdo_theme_flag_classes ) ); ?>">
					<?php include $mkdo_theme_file; ?>
				</div>

				<hr class="static-hr"/>

				<?php
				unset( $mkdo_theme_flags, $mkdo_theme_flag_classes );
			}  // End loop files.
			?>

		</section>

	<?php
	} // End loop folders.
	get_footer();
	?>

</div>
