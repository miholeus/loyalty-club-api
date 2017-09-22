<?php
/**
 * @package    Zenomania\ApiBundle\Form
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 */

namespace Zenomania\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zenomania\ApiBundle\Form\Model\EventScore;

class EventScorePredictionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('result', TextType::class, [
            'label' => 'Итог матча'
        ]);
        $builder->add('scores', CollectionType::class, [
            'entry_type' => EventScoreType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [],
            'by_reference' => false,
//            'mapped' => false,
            'required' => true,
            'description' => 'Очки в партиях',
        ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $e) {
            $form = $e->getForm();
            $data = $e->getData();

            $items = [];
            if (!empty($data['scores'])) {
                foreach ($data['scores'] as $score) {
                    if (!empty($score['score'])) {
                        $scoreItem = new EventScore();
                        $scoreItem->setScore($score['score']);
                        $items[] = $scoreItem;
                    }
                }
            }

            if (empty($items)) {
                $form['scores']->addError(new FormError("Scores must not be empty"));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zenomania\ApiBundle\Form\Model\EventScorePrediction',
        ));
    }

    public function getBlockPrefix()
    {
        return 'scores';
    }
}