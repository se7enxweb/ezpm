{def $site_url=ezini( 'SiteSettings', 'SiteURL' )}
{set-block scope=root variable=subject}{'New message in your inbox'|i18n('design/standard/ezpm')}{/set-block}
{'Hello %first_name.'|i18n('design/standard/user/register',,hash('%first_name',$first_name))}

{'Click the following URL to access your inbox'|i18n('design/standard/ezpm')}:
http://{$hostname}{concat( 'pm/message/', $messageID )|ezurl(no)}