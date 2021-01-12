<?php

namespace RevisionsExtended\Post_Status;

defined( 'WPINC' ) || die();

/**
 * Actions and filters.
 */
add_action( 'init', __NAMESPACE__ . '\register' );

/**
 * Register post statuses.
 *
 * @return void
 */
function register() {
	register_post_status(
		'revex_pending',
		array(
			'label'                     => __( 'Pending Revision', 'revisions-extended' ),
			'labels'                    => (object) array(
				'publish' => __( 'Publish Revision', 'revisions-extended' ),
				'save'    => __( 'Save Revision', 'revisions-extended' ),
				'update'  => __( 'Update Revision', 'revisions-extended' ),
				'plural'  => __( 'Pending Revisions', 'revisions-extended' ),
				'short'   => __( 'Pending', 'revisions-extended' )
			),
			'protected'                 => true,
			'internal'                  => true,
			'label_count'               => _n_noop(
				'Pending <span class="count">(%s)</span>',
				'Pending <span class="count">(%s)</span>',
				'revisions-extended'
			),
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => false,
			'revisions_extended'        => true,
		)
	);

	register_post_status(
		'revex_future',
		array(
			'label'                     => __( 'Scheduled Revision', 'revisions-extended' ),
			'labels'                    => (object) array(
				'publish' => __( 'Publish Revision', 'revisions-extended' ),
				'save'    => __( 'Save Revision', 'revisions-extended' ),
				'update'  => __( 'Update Revision', 'revisions-extended' ),
				'plural'  => __( 'Scheduled Revisions', 'revisions-extended' ),
				'short'   => __( 'Scheduled', 'revisions-extended' )
			),
			'protected'                 => true,
			'internal'                  => true,
			'label_count'               => _n_noop(
				'Scheduled <span class="count">(%s)</span>',
				'Scheduled <span class="count">(%s)</span>',
				'revisions-extended'
			),
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => false,
			'revisions_extended'        => true,
		)
	);
}

/**
 * Get array of revision-specific post status objects.
 *
 * @return object[]
 */
function get_revision_statuses() {
	return get_post_stati(
		array(
			'revisions_extended' => true,
		),
		'objects'
	);
}

/**
 * Check if a given status is a valid revision status.
 *
 * Note that this does not include the 'inherit' status used by the Core revision system.
 *
 * @param string $status
 *
 * @return bool
 */
function validate_revision_status( $status ) {
	$statuses = wp_list_pluck( get_revision_statuses(), 'name' );

	return in_array( $status, $statuses, true );
}
