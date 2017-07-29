# Mpchadwick_MwscanUtils

A set of utilities for use in tandem with [magento-malware-scanner](https://github.com/gwillem/magento-malware-scanner).

## Features

### Content Dump Endpoint

Adds an endpoint at `/mwscanutils/contentdump` which returns a `text/plain` response including...

- Content from ALL CMS pages
- Content from ALL CMS blocks
- Miscellaneous Scripts
- Miscellaneous HTML

From a scanning location, you should send the output of this to mwscan.

```
curl --silent https://example.com/mwscanutils/content > content && grep -Erlf mwscan.txt content
```

Additional content can be appended as needed by observing the `mpchadwick_mwscanutils_dump_content_before` event

**config.xml**

```xml
<mpchadwick_mwscanutils_dump_content_before>
    <observers>
        <example>
            <model>example/observer</model>
            <method>appendContent</method>
        </example>
    </observers>
</mpchadwick_mwscanutils_dump_content_before>
```

**Observer.php**

```php
public function appendContent(Varien_Event_Observer $observer)
{
    $container = $observer->getContainer();
    $content = $container->getContent();
    $content[] = 'Dump this too.';
    $container->setContent($content);
}
```

### /checkout/onepage HTML

Adds the ability to fetch the HTML for `/checkout/onepage` programmatically. Pass the `mwscanutils_force` param as follows...

```
curl --silent https://example.com/checkout/onepage/index/mwscanutils_force/1 > content && grep -Erlf mwscan.txt content
```

A dummy product will be added to the quote to allow the page to render.

Helpful for catching cases where the malware is only present on the checkout page.
