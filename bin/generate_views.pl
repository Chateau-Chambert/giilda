#!/usr/bin/perl

$dbconfig = shift();
$tmpfile = "/tmp/$$.json";
use JSON -support_by_pp;

open(CONF, $dbconfig);
while (<CONF>) {
	chomp;
	if (/dsn:\s*([^ ]*)/) {
		$db = $1;
	}
	if (/dbname:\s*([^ ]*)/) {
		$dbname = $1;
	}
	if ($db && $dbname) {
		$couchurl = $db.$dbname;
		last;
	}
}
close(CONF);

my %views;
foreach $file (@ARGV) {
	if ($file =~ /\/([^\/\.]*)\.([^\/\.]*)\.(map|reduce)\.view\.js$/) {
		open(JS, $file);
		@str = <JS>;
		$str = "@str";
		$design = $1;
		
		$views{$design}{'views'}{$2}{$3} = $str if ($str);
		if (!$views{$design}{'language'}) {
		        $views{$design}{'language'} = 'javascript';
	        	$views{$design}{'_id'} = '_design/'.$design;
			open(COUCH, 'curl -s '.$couchurl.'/_design/'.$design.' | ');
			$str = <COUCH>;
			close COUCH;

			if ($str =~ /rev":"([^"]*)"/) {
			    $views{$design}{'_rev'} = $1;
			}
		}
	}
}

foreach $design (keys %views) {	
	if ($design) {
	    open JSON, '> '.$tmpfile;
	    print JSON to_json( $views{$design}, { ascii => 1, pretty => 1 } );
	    close JSON;
	    open(COUCH, 'curl -s -X PUT -d "@'.$tmpfile.'" '.$couchurl.'/_design/'.$design.' | ');
	    print <COUCH>;
	    close COUCH;
	}
}

unlink($tmpfile);
