/*
 * ezpm: the private message lists without inline code, so they work under a Content Security Policy without
 * 'unsafe-inline'. What the onclick attributes did is done here:
 *
 *   data-ezpm-toggle-form="messages" data-ezpm-toggle-name="DeleteIDArray[]"
 *                          the "Toggle selection" icon inverts the checkboxes of that name in that form
 *   data-ezpm-href="url"   a cell of a message row opens the message
 *
 * Plain JavaScript, delegated listeners. Set up once, however often this file is printed.
 */
( function()
{
    if ( window.eZPM ) return;
    window.eZPM = { 'version': 1 };

    document.addEventListener( 'click', function( e )
    {
        var el = e.target && e.target.closest ? e.target.closest( '[data-ezpm-toggle-form], [data-ezpm-href]' ) : null;
        if ( !el ) return;
        if ( el.hasAttribute( 'data-ezpm-href' ) )
        {
            document.location.href = el.getAttribute( 'data-ezpm-href' );
            return;
        }
        e.preventDefault();
        var form = document.forms[el.getAttribute( 'data-ezpm-toggle-form' )], name = el.getAttribute( 'data-ezpm-toggle-name' );
        if ( !form ) return;
        for ( var i = 0; i < form.elements.length; i++ )
        {
            if ( form.elements[i].type == 'checkbox' && form.elements[i].name == name && !form.elements[i].disabled )
            {
                form.elements[i].checked = !form.elements[i].checked;
            }
        }
    } );
} )();
