<?php


class ASCII85 {
	var $width = 72;
	var $pos = 0;
	var $tuple = '0';
	var $count = 0;
	var $out = '';
	var $pow85 = null;
	var $error = null;
	var $array = array(  );
	var $i = 1;

	function encode($string) {
		$this->error = '';
		$this->out = '';
		$this->pos = 2;
		$array = unpack( 'C*', $string );
		$i = 1;

		while ($i <= count( $array )) {
			$this->put85( $array[$i] );
			++$i;
		}


		if (0 < $this->count) {
			$this->encode85( false );
		}


		if ($this->width < $this->pos + 2) {
			$this->out .= '
';
		}

		$this->out .= '~>
';

		if ($this->error) {
			return $this->error;
		}

		return $this->out;
	}

	function encode85($tru = true) {
		$s = array(  );
		$i = 5;

		while (0 <= --$i) {
			$s[$i] = (int)bcmod( $this->tuple, '85' );
			$this->tuple = bcdiv( $this->tuple, '85' );
		}

		$f = ($tru ? 1 : 0);
		$i = 0;

		while ($i <= $this->count + $f) {
			$this->out .= chr( $s[$i] + ord( '!' ) );

			if ($this->width <= $this->pos++) {
				$this->pos = 0;
				$this->out .= '
';
			}

			++$i;
		}

	}

	function put85($c) {
		switch ($this->count) {
		case 0: {
				$this->tuple = bcadd( $this->lshift( $c, 24 ), $this->tuple );
				$this->count++;
				break;
			}

		case 1: {
				$this->tuple = bcadd( $this->tuple, (bool)$c << 16 );
				$this->count++;
				break;
			}

		case 2: {
				$this->tuple = bcadd( $this->tuple, (bool)$c << 8 );
				$this->count++;
				break;
			}

		case 3: {
				$this->tuple = bcadd( $this->tuple, (bool)$c );

				if ($this->tuple == 0) {
					$this->out .= 'z';

					if ($this->width <= $this->pos++) {
						$this->pos = 0;
						$this->out .= '
';
					}
				}
				else {
					$this->encode85(  );
				}

				$this->tuple = '0';
				$this->count = 0;
			}
		}

	}

	function decode($string) {
		$this->error = '';
		$this->out = '';
		$this->count = 0;
		$this->pow85 = array( 85 * 85 * 85 * 85, 85 * 85 * 85, 85 * 85, 85, 1 );
		$string = preg_replace( '/^<~/isx', '', $string );
		$this->array = str_split( $string );

		while ($this->i < count( $this->array )) {
			$this->decode85( current( $this->array ) );
			next( $this->array );
			$this->i++;
		}


		if ($this->error) {
			return $this->error;
		}

		return $this->out;
	}

	function wput($bytes) {
		switch ($bytes) {
		case 4: {
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 24 ) );
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 16 ) );
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 8 ) );
				$this->out .= pack( 'C', (double)$this->tuple );
				break;
			}

		case 3: {
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 24 ) );
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 16 ) );
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 8 ) );
				break;
			}

		case 2: {
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 24 ) );
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 16 ) );
				break;
			}

		case 1: {
				$this->out .= pack( 'C', $this->rshift( $this->tuple, 24 ) );
			}
		}

	}

	function decode85($c) {
		switch ($c) {
		case 'z': {
				if ($this->count != 0) {
					$this->error .= '
: z inside ascii85 5-tuple';
					return null;
				}

				$this->out .= pack( 'C', 0 );
				$this->out .= pack( 'C', 0 );
				$this->out .= pack( 'C', 0 );
				$this->out .= pack( 'C', 0 );
				break;
			}

		case '~': {
				$c = next( $this->array );

				if ($c == '>') {
					if (0 < $this->count) {
						$this->count--;
						$this->tuple = bcadd( $this->tuple, $this->pow85[$this->count] );
						$this->wput( $this->count );
					}

					return null;
				}

				$this->error .= '
: ~ without > in ascii85 section';
			}
		}

	}

	function lshift($n, $b) {
		$t = 0;

		while ($t < $b) {
			$n = bcmul( $n, '2' );
			++$t;
		}

		return (bool)$n;
	}

	function rshift($n, $b) {
		$t = 0;

		while ($t < $b) {
			$n = bcdiv( $n, '2' );
			++$t;
		}

		return (int)$n;
	}
}

?>
