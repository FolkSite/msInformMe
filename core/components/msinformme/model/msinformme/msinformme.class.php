<?php

class msInformMe
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('msinformme_core_path', $config,
            $this->modx->getOption('core_path') . 'components/msinformme/'
        );
        $assetsUrl = $this->modx->getOption('msinformme_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/msinformme/'
        );
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'templatesPath' => $corePath . 'elements/templates/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'processorsPath' => $corePath . 'processors/',
        ), $config);

        $this->modx->addPackage('msinformme', $this->config['modelPath']);
        $this->modx->lexicon->load('msinformme:default');
    }

    /**
     * @param $templateId
     * @param array $scriptProperties
     * @return bool|mixed
     */
    public function getTemplate($templateId, array $scriptProperties)
    {
        $template = $this->modx->getObject('modTemplate', $templateId);
        if (!$template || !($template instanceof modTemplate)) {
            return false;
        }
        $template = $template->process($scriptProperties);
        return $this->_parserTag($template);
    }

    /**
     * @param $id
     * @return array
     */
    public function getProduct($id)
    {
        $scriptProperties = [];

        $q = $this->modx->newQuery('modResource', (int) $id);
        $data = $this->modx->getIterator('modResource', $q);

        $data->rewind();
        if ($data->valid()) {
            foreach ($data as $k => $v) {
                $scriptProperties['product'] = $v->toArray();
            }
        }
        return $scriptProperties;
    }

    /**
     * @param $email
     * @return array
     */
    public function getUser($email)
    {
        $scriptProperties = [];

        if ($profile = $this->modx->getObject('modUserProfile', array('email' => $email))) {
            $user = $profile->getOne('User');

            $scriptProperties['user'] = $user->toArray();
            $scriptProperties['profile'] = $profile->toArray();
        }
        return $scriptProperties;
    }

    /**
     * @param array $send
     * @return array|bool
     */
    public function sendEmail(array $send) {
        /** @var modPHPMailer $mail */
        $mail = $this->modx->getService('mail', 'mail.modPHPMailer');

        $mail->set(modMail::MAIL_BODY, $send['template']);
        $mail->set(modMail::MAIL_FROM, $send['from']);
        $mail->set(modMail::MAIL_FROM_NAME, $send['from_name']);
        $mail->set(modMail::MAIL_SUBJECT, $send['subject']);
        $mail->address('to', $send['email']);
        $mail->address('reply-to', $send['replyTo']);
        $mail->setHTML(true);
        if (!$mail->send()) {
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, 'An error occurred while trying to send the email: '
                . $mail->mailer->ErrorInfo);
            $mail->reset();
            $result = [];
            $result['result'] = false;
            $result['messages'] = $mail->mailer->ErrorInfo;
            return $result;
        }
        else {
            $mail->reset();
            return true;
        }
    }

    /**
     * @param $content
     * @return mixed
     */
    private function _parserTag($content)
    {
        $this->modx->getParser()
            ->processElementTags('', $content, false, false, '[[', ']]', array(), 10);
        $this->modx->getParser()
            ->processElementTags('', $content, true, true, '[[', ']]', array(), 10);
        return $content;
    }
}