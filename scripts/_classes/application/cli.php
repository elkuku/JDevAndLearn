<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/19/12
 * Time: 2:34 AM
 * To change this template use File | Settings | File Templates.
 */

require getenv('KUKU_JLIB_PATH').'/loader.php';

class JdlApplicationCli extends KukuApplicationCli
{
    /**
     * @var SimpleXMLElement
     */
    protected $configXml = null;

    /**
     * Class constructor.
     *
     * @param   mixed  $input       An optional argument to provide dependency injection for the application's
     *                              input object.  If the argument is a JInputCli object that object will become
     *                              the application's input object, otherwise a default input object is created.
     * @param   mixed  $config      An optional argument to provide dependency injection for the application's
     *                              config object.  If the argument is a JRegistry object that object will become
     *                              the application's config object, otherwise a default config object is created.
     * @param   mixed  $dispatcher  An optional argument to provide dependency injection for the application's
     *                              event dispatcher.  If the argument is a JEventDispatcher object that object will become
     *                              the application's event dispatcher, if it is null then the default event dispatcher
     *                              will be created based on the application's loadDispatcher() method.
     *
     * @throws DomainException
     * @see     loadDispatcher()
     * @since   11.1
     */
    public function __construct(JInputCli $input = null, JRegistry $config = null, JEventDispatcher $dispatcher = null)
    {
        $path = JDLPATH_SCRIPTS.'/config.xml';

        if(false == file_exists($path))
            throw new DomainException('ERROR: Config file not found at:'.$path);

        $this->configXml = simplexml_load_file($path);

        if(false == $this->configXml)
            throw new DomainException('ERROR: Invalid config at:'.$path);

        parent::__construct($input, $config, $dispatcher);
    }
}
