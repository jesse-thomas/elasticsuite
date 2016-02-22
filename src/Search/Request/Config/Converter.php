<?php
/**
 * DISCLAIMER :
 *
 * Do not edit or add to this file if you wish to upgrade Smile Elastic Suite to newer
 * versions in the future.
 *
 * @category  Smile_ElasticSuite
 * @package   Smile\ElasticSuiteCore
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2016 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticSuiteCore\Search\Request\Config;

use Smile\ElasticSuiteCore\Api\Index\Mapping\DynamicFieldProviderInterface;


class Converter extends \Magento\Framework\Search\Request\Config\Converter
{
/**
     * Convert config.
     *
     * @param \DOMDocument $source
     * @return array
     */
    public function convert($source)
    {
        // Due to SimpleXML not deleting comment we have to strip them before using the source.
        $source = $this->stripComments($source);

        /** @var \DOMNodeList $requestNodes */
        $requestNodes = $source->getElementsByTagName('request');
        $requests = [];
        foreach ($requestNodes as $requestNode) {
            $simpleXmlNode = simplexml_import_dom($requestNode);
            /** @var \DOMElement $requestNode */
            $name = $requestNode->getAttribute('name');
            $request = $this->mergeAttributes((array)$simpleXmlNode);
            $request['dimensions'] = $this->convertNodes($simpleXmlNode->dimensions, 'name');
            $request['queries'] = $this->convertNodes($simpleXmlNode->queries, 'name');
            $request['query'] = $this->mergeAttributes((array) $simpleXmlNode->query, 'query');
            $request['filter'] = $this->mergeAttributes((array) $simpleXmlNode->filter, 'query');
            $request['aggregations'] = $this->convertNodes($simpleXmlNode->aggregations, 'name');
            $requests[$name] = $request;
        }

        return $requests;
    }

    /**
     * This method clean the comments of an XML document.
     *
     * @param \DOMDocument $source
     *
     * @return \DOMDocument
     */
    private function stripComments(\DOMDocument $source) {
        $xpath = new \DOMXPath($source);

        foreach ($xpath->query('//comment()') as $commentNode) {
            $commentNode->parentNode->removeChild($commentNode);
        }

        return $source;
    }
}
