# Mpchadwick_MwscanUtils

A set of utilities for use in tandem with [magento-malware-scanner](https://github.com/gwillem/magento-malware-scanner).

## Feature

### Content Dump Endpoint

Adds an endpoint at /mwscanutils/content which returns a text/plain response including

- Content from ALL CMS pages
- Content from ALL CMS blocks
- Miscellaneous Scripts
- Miscellaneous HTML

From a scanning location, you should send the output of this to mwscan.

```
curl --silent https://example.com/mwscanutils/content > content && grep -Erlf mwscan.txt content
```
