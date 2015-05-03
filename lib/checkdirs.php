<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2012 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

if (ini_get('mbstring.func_overload') != '0') {
    die('Prosze zmienic wartosc zmiennej mbstring.func_overload = 0 w /etc/php5/apache2/php.ini i przeladowac serwer apache');
}
if(!is_dir(SMARTY_COMPILE_DIR))
	die('Missing directory <B>'.SMARTY_COMPILE_DIR.'</B>. Can anybody make them?');

if(!is_writable(SMARTY_COMPILE_DIR))
	die('Can\'t write to directory <B>'.SMARTY_COMPILE_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.SMARTY_COMPILE_DIR."\nchmod 755 ".SMARTY_COMPILE_DIR.'</PRE>This helps me to work. Thanks.');

if(!is_dir(BACKUP_DIR))
	die('Missing directory <B>'.BACKUP_DIR.'</B>. Can anybody make them?');
	
if(!is_writable(BACKUP_DIR))
	die('Can\'t write to directory <B>'.BACKUP_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.BACKUP_DIR."\nchmod 755 ".BACKUP_DIR.'</PRE>This helps me to work. Thanks.');

if(!is_dir(DOC_DIR))
	die('Missing directory <B>'.DOC_DIR.'</B>. Can anybody make them?');
	
if(!is_writable(DOC_DIR))
	die('Can\'t write to directory <B>'.DOC_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.DOC_DIR."\nchmod 755 ".DOC_DIR.'</PRE>This helps me to work. Thanks.');

if(!is_dir(TMP_DIR))
	die('Missing directory <B>'.TMP_DIR.'</B>. Can anybody make them?');
	
if(!is_writable(TMP_DIR))
	die('Can\'t write to directory <B>'.TMP_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.TMP_DIR."\nchmod 755 ".TMP_DIR.'</PRE>This helps me to work. Thanks.');

if(!is_dir(RRD_DIR))
	die('Missing directory <B>'.RRD_DIR.'</B>. Can anybody make them?');
	
if(!is_writable(RRD_DIR))
	die('Can\'t write to directory <B>'.RRD_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.RRD_DIR."\nchmod 755 ".RRD_DIR.'</PRE>This helps me to work. Thanks.');

if(!is_dir(UPLOADFILES_DIR))
	die('Missing directory <B>'.UPLOADFILES_DIR.'</B>. Can anybody make them?');
	
if(!is_writable(UPLOADFILES_DIR))
	die('Can\'t write to directory <B>'.UPLOADFILES_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.UPLOADFILES_DIR."\nchmod 755 ".UPLOADFILES_DIR.'</PRE>This helps me to work. Thanks.');

//if(!is_dir(PLUG_DIR))
//	die('Missing directory <B>'.PLUG_DIR.'</B>. Can anybody make them?');
	
//if(!is_writable(PLUG_DIR))
//	die('Can\'t write to directory <B>'.PLUG_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.PLUG_DIR."\nchmod 755 ".PLUG_DIR.'</PRE>This helps me to work. Thanks.');

if(!is_dir(INVOICE_DIR))
	die('Missing directory <B>'.INVOICE_DIR.'</B>. Can anybody make them?');
	
if(!is_writable(INVOICE_DIR))
	die('Can\'t write to directory <B>'.INVOICE_DIR.'</B>. Run: <BR><PRE>chown '.posix_geteuid().':'.posix_getegid().' '.INVOICE_DIR."\nchmod 755 ".INVOICE_DIR.'</PRE>This helps me to work. Thanks.');


?>
