<?php
/**
 * Created by PhpStorm.
 * User: Antis
 * Date: 27.11.2016
 * Time: 17:05
 */
/* @var $this yii\web\View */

/* @var $manufacturer \frontend\models\Manufacturer */
/*  models  */

/*  widgets  */
use yii\helpers\Html;
use yii\helpers\Url;

/*  assets  */
use app\assets\PagesAsset;
PagesAsset::register($this);

$this->params['breadcrumbs'][] = [
    'label' => 'Производители',
    'url' => Url::to(['pages/dveri']),
    'template' => "<li> {link} </li>\n", // template for this link only

];
$nameFactory = 'Agoprofil';
$title = 'Традиции и инновации';

Yii::setAlias('@imgBigLogos', '@web/img/catalog/logos/big');
?>
<div class="wrap order-registration">
    <div class="confirm-orders-title"><?=$nameFactory?> - <?=$title?></div>
    <div class="generic">
        <?=  Html::img('@imgBigLogos/agoprofil-logo.png')?>
        <p>
            Популярная мебельная фабрика AGOPROFIL ведет коммерческую деятельность с далекого 1972 года. Из них на российском рынке марка присутствует 10 лет, и за этот срок она успела полюбиться множеству покупателей. Свою деятельность AGOPROFIL начинала с изготовления классических итальянских дверей из дерева. Со временем старые ремесленные традиции были не просто сохранены, но скомбинированы с различными современными способами производства и дизайна. Сегодня фабрика специализируется на межкомнатных дверях.
        </p>
        <h3>Какие преимущества таят в себе двери AGOPROFIL?</h3>
        <ul>
            <li>Классический стиль, сочетающий в себе прошлое, настоящее и будущее;</li>
            <li>Инновационный подход, гарантирующие оптимальные технические характеристики и максимальное удобство
                монтажа;
            </li>
            <li>Разнообразие моделей, подходящих как для жилых, так и для офисных помещений;</li>
            <li>Узнаваемый дизайн, нарочитая простота форм и удивительно долгий срок службы.</li>
        </ul>
        <p>
            Помимо этого, сегодня AGOPROFIL имеет собственное проектное бюро, где очень  чутко реагируют на желания потребителей.
            Компания имеет особый сертификат системы качества UNI EN ISO 9001. Это не просто признак того, что предприятию можно доверять, но еще и доказательство способности фабрики гибко реагировать на изменения потребностей рынка. Сертификат свидетельствует о грамотном проектировании и разработке индивидуальных архитектурных решений.
            В любой серии дверей, выпускаемых фабрикой, есть модели, сделанные из шпона, из массива и с сотовым наполнением. AGOPROFIL изготавливает и все виды дверных аксессуаров. Сами двери изготавливают в нескольких основных вариантах: распашные, раздвижные двери, и «книжки».
            Оформление двери может быть практически любым: от строгой классики до дверей с позолотой, ручной росписью и прочими атрибутами премиум-класса.
        </p>
        <h3>
            Чтобы было проще найти нужное вам среди всего изобилия моделей, кратко расскажем о каждой серии дверей от AGOPROFIL:
        </h3>
        <ul>
            <li>Серия Class характеризуется строгим классическим дизайном. Двери изготавливаются из древесины.</li>
            <li>Crystal можно расшифровать как кристальную чистоту в оформлении. Количество украшений на деревянных дверях этой серии минимально.</li>
            <li>Diamond изготавливается из шпона. Двери этой серии отличаются наличием матовых стекол.</li>
            <li>Double round похож на серию Diamond, только стеклянные вставки здесь более широкие и напоминают небольшие окна.</li>
            <li>Elegance характеризуется массивными косяками. В дизайне присутствуют овальные вставки из матового стекла.</li>
            <li>Fun отличается яркой расцветкой дверей и создана специально для тех, кто хочет бросить вызов скучной повседневности.</li>
        </ul>
        <p>Компания "Абсолют Интерьер" рада предложить широкий выбор дверей AGOPROFIL.</p>
        <a href="http://www.agoprofil.com/ru/">Перейти официальный сайт</a>
    </div>
</div>