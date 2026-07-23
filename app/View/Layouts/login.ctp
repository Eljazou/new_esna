<?php
/**
 * `login` layout — a deliberately bare wrapper: the views that use it render a
 * complete HTML document themselves (Users/login.ctp), or are AJAX fragments
 * injected into an existing page (Clients/system_recherche.ctp).
 *
 * Flash rendering moved from Session->flash() to the shared Metronic element so
 * messages are styled server-side. Users/login.ctp previously restyled them
 * with a $(window).load() handler; that handler is gone, so without this the
 * login page would show a raw unstyled <div class="message">.
 */
echo $this->element('layout/flash');
echo $this->fetch('content');
