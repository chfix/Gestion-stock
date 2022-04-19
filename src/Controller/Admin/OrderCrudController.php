<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            AssociationField::new('Product')->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                $queryBuilder->where('entity.active = true');
            }),

            MoneyField::new('unity_price')->setCurrency('EUR')->hideOnForm(),

            IntegerField::new('quantity'),

            MoneyField::new('total_price')->setCurrency('EUR')->hideOnForm(),


            DateTimeField::new('updatedAt')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Order) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable);

        $product = $entityInstance->getProduct();

        
        $uprice = $product->getPrice();
        $entityInstance->setUnityPrice($uprice);

        $pqte = $product->getQuantity();
        $qte = $entityInstance->getQuantity();

        $product->setQuantity($pqte-$qte);
        $entityInstance->setTotalPrice($qte*$uprice);
        parent::persistEntity($em, $entityInstance);     
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Order) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::updateEntity($em, $entityInstance);
    }
}
