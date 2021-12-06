<?php

namespace ConfigManager\Bundle\ClientBundle\Form\Type;

use ConfigManager\Bundle\ClientBundle\Service\ParametroService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametroChoiceType extends AbstractType
{
    /** @required */
    public ParametroService $parametroService;

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('dominio');
        $resolver->setAllowedTypes('dominio', 'string');

        $resolver->setDefaults([
            'placeholder' => 'crud.form.choice_placeholder',
            'translation_domain' => 'MicayaelCrudBundle',
            'choice_loader' => function (Options $options) {
                $data = $this->parametroService->getParametro($options['dominio']);

                $data = array_shift($data);

                return new CallbackChoiceLoader(function () use ($data) {
                    return array_combine($data, $data);
                });
            },
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
