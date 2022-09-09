<?php
/**
 * Book type.
 */

namespace App\Form\Type;

use App\Entity\AuthorInfo;
use App\Entity\Category;
use App\Entity\Book;
use App\Entity\PublishingHouseInfo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookType.
 */
class BookType extends AbstractType
{
    /**
     * Data transformer.
     */
    private TagsDataTransformer $tagsDataTransformer;

    /**
     * construct function.
     *
     * @param TagsDataTransformer $tagsDataTransformer Data transformer
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'description',
            TextType::class,
            [
                'label' => 'label.description',
                'required' => true,
                'attr' => ['max_length' => 400],
            ]
        );
        $builder->add(
            'price',
            IntegerType::class,
            [
                'label' => 'label.price',
                'required' => true,
            ]
        );
        $builder->add(
            'authorInfo',
            EntityType::class,
            [
                'class' => AuthorInfo::class,
                'choice_label' => function ($bookAuthor): string {
                    return $bookAuthor->getname();
                },
                'label' => 'label.AuthorInfo',
                'placeholder' => 'label.none',
                'required' => true,
            ]
        );
        $builder->add(
            'PublishingHouseInfo',
            EntityType::class,
            [
                'class' => PublishingHouseInfo::class,
                'choice_label' => function ($publishingHouseInfo): string {
                    return $publishingHouseInfo->getname();
                },
                'label' => 'label.PublishingHouseInfo',
                'placeholder' => 'label.none',
                'required' => true,
            ]
        );
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category): string {
                    return $category->getName();
                },
                'label' => 'label.category',
                'placeholder' => 'label.none',
                'required' => true,
            ]
        );

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label.tags',
                'required' => false,
                'attr' => ['max_length' => 300],
            ]
        );
        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Book::class,
                'csrf_token_id' => 'form_intention',
            ],
        );
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'book';
    }
}
