<?php
/*--------------------------------------------------------------------------

	sample-ridirect

	@memo

---------------------------------------------------------------------------*/

	/* redirect */
	header('Location: ' . home_url( '/' ) ); // top || マルチサイト c_child top
	header('Location: ' . home_url( '/' . DIRCODE . '/' ) ); // dir top
	header('Location: ' . network_home_url( '/' ) ); // マルチサイト base top

	/*---------------------------------------------------------------------------*/