<?php

class HTMLTemplateDeliverySlip extends HTMLTemplateDeliverySlipCore {};
class HTMLTemplateSupplyOrderForm extends HTMLTemplateSupplyOrderFormCore {};
abstract class HTMLTemplate extends HTMLTemplateCore {};
class HTMLTemplateOrderSlip extends HTMLTemplateOrderSlipCore {};
class HTMLTemplateInvoice extends HTMLTemplateInvoiceCore {};
class HTMLTemplateOrderReturn extends HTMLTemplateOrderReturnCore {};
class PDF extends PDFCore {};
class PDFGenerator extends PDFGeneratorCore {};
class Customer extends CustomerCore {};
class CustomerAddress extends CustomerAddressCore {};
class Gender extends GenderCore {};
class Combination extends CombinationCore {};
class Upgrader extends UpgraderCore {};
class Store extends StoreCore {};
class Cart extends CartCore {};
class Windows extends WindowsCore {};
class CMSCategory extends CMSCategoryCore {};
class Language extends LanguageCore {};
class LocalizationPack extends LocalizationPackCore {};
class ImageType extends ImageTypeCore {};
class SupplyOrderHistory extends SupplyOrderHistoryCore {};
class SupplyOrder extends SupplyOrderCore {};
class StockAvailable extends StockAvailableCore {};
class Stock extends StockCore {};
class StockMvt extends StockMvtCore {};
class WarehouseProductLocation extends WarehouseProductLocationCore {};
class StockManager extends StockManagerCore {};
class SupplyOrderDetail extends SupplyOrderDetailCore {};
class StockMvtReason extends StockMvtReasonCore {};
class StockMvtWS extends StockMvtWSCore {};
class SupplyOrderReceiptHistory extends SupplyOrderReceiptHistoryCore {};
abstract class StockManagerModule extends StockManagerModuleCore {};
class SupplyOrderState extends SupplyOrderStateCore {};
class StockManagerFactory extends StockManagerFactoryCore {};
class Warehouse extends WarehouseCore {};
class PrestaShopLogger extends PrestaShopLoggerCore {};
class Profile extends ProfileCore {};
class SpecificPriceRule extends SpecificPriceRuleCore {};
class FileLogger extends FileLoggerCore {};
abstract class AbstractLogger extends AbstractLoggerCore {};
abstract class PaymentModule extends PaymentModuleCore {};
class FrontController extends FrontControllerCore {};
abstract class ModuleAdminController extends ModuleAdminControllerCore {};
class AdminController extends AdminControllerCore {};
class ModuleFrontController extends ModuleFrontControllerCore {};
abstract class ProductPresentingFrontController extends ProductPresentingFrontControllerCore {};
abstract class ProductListingFrontController extends ProductListingFrontControllerCore {};
abstract class Controller extends ControllerCore {};
class Currency extends CurrencyCore {};
class PrestaShopBackup extends PrestaShopBackupCore {};
class ImageManager extends ImageManagerCore {};
class ProductDownload extends ProductDownloadCore {};
class Country extends CountryCore {};
class OrderInvoice extends OrderInvoiceCore {};
class Order extends OrderCore {};
class OrderDiscount extends OrderDiscountCore {};
class OrderHistory extends OrderHistoryCore {};
class OrderState extends OrderStateCore {};
class OrderMessage extends OrderMessageCore {};
class OrderReturnState extends OrderReturnStateCore {};
class OrderCarrier extends OrderCarrierCore {};
class OrderReturn extends OrderReturnCore {};
class OrderSlip extends OrderSlipCore {};
class OrderDetail extends OrderDetailCore {};
class OrderCartRule extends OrderCartRuleCore {};
class OrderPayment extends OrderPaymentCore {};
class FileUploader extends FileUploaderCore {};
class Cookie extends CookieCore {};
class PaymentOptionsFinder extends PaymentOptionsFinderCore {};
class CheckoutProcess extends CheckoutProcessCore {};
class CheckoutPaymentStep extends CheckoutPaymentStepCore {};
class CheckoutDeliveryStep extends CheckoutDeliveryStepCore {};
class CartChecksum extends CartChecksumCore {};
class AddressValidator extends AddressValidatorCore {};
abstract class AbstractCheckoutStep extends AbstractCheckoutStepCore {};
class ConditionsToApproveFinder extends ConditionsToApproveFinderCore {};
class DeliveryOptionsFinder extends DeliveryOptionsFinderCore {};
class CheckoutPersonalInformationStep extends CheckoutPersonalInformationStepCore {};
class CheckoutAddressesStep extends CheckoutAddressesStepCore {};
class CheckoutSession extends CheckoutSessionCore {};
class Zone extends ZoneCore {};
class Configuration extends ConfigurationCore {};
class Context extends ContextCore {};
class Alias extends AliasCore {};
class Link extends LinkCore {};
class Tools extends ToolsCore {};
class Access extends AccessCore {};
class Attachment extends AttachmentCore {};
class Image extends ImageCore {};
class ProductAssembler extends ProductAssemblerCore {};
abstract class ModuleGrid extends ModuleGridCore {};
abstract class CarrierModule extends CarrierModuleCore {};
abstract class ModuleGraphEngine extends ModuleGraphEngineCore {};
abstract class ModuleGraph extends ModuleGraphCore {};
abstract class Module extends ModuleCore {};
abstract class ModuleGridEngine extends ModuleGridEngineCore {};
class SupplierAddress extends SupplierAddressCore {};
class Employee extends EmployeeCore {};
class QuickAccessLang extends QuickAccessLangCore {};
class ProfileLang extends ProfileLangCore {};
class AttributeGroupLang extends AttributeGroupLangCore {};
class SupplyOrderStateLang extends SupplyOrderStateLangCore {};
class FeatureValueLang extends FeatureValueLangCore {};
class CategoryLang extends CategoryLangCore {};
class OrderStateLang extends OrderStateLangCore {};
class FeatureLang extends FeatureLangCore {};
class RiskLang extends RiskLangCore {};
class StockMvtReasonLang extends StockMvtReasonLangCore {};
class CmsCategoryLang extends CmsCategoryLangCore {};
class ThemeLang extends ThemeLangCore {};
class OrderReturnStateLang extends OrderReturnStateLangCore {};
class ConfigurationLang extends ConfigurationLangCore {};
class CarrierLang extends CarrierLangCore {};
class MetaLang extends MetaLangCore {};
class GenderLang extends GenderLangCore {};
class DataLang extends DataLangCore {};
class TabLang extends TabLangCore {};
class AttributeLang extends AttributeLangCore {};
class OrderMessageLang extends OrderMessageLangCore {};
class GroupLang extends GroupLangCore {};
class ContactLang extends ContactLangCore {};
abstract class ObjectModel extends ObjectModelCore {};
class Manufacturer extends ManufacturerCore {};
class Carrier extends CarrierCore {};
class CustomerThread extends CustomerThreadCore {};
class DbPDO extends DbPDOCore {};
class DbQuery extends DbQueryCore {};
abstract class Db extends DbCore {};
class DbMySQLi extends DbMySQLiCore {};
class Search extends SearchCore {};
class Supplier extends SupplierCore {};
class CssMinifier extends CssMinifierCore {};
class JsMinifier extends JsMinifierCore {};
abstract class AbstractAssetManager extends AbstractAssetManagerCore {};
class StylesheetManager extends StylesheetManagerCore {};
class CccReducer extends CccReducerCore {};
class JavascriptManager extends JavascriptManagerCore {};
class Contact extends ContactCore {};
class AddressChecksum extends AddressChecksumCore {};
class Risk extends RiskCore {};
class Media extends MediaCore {};
class Tax extends TaxCore {};
class TaxRulesGroup extends TaxRulesGroupCore {};
abstract class TaxManagerModule extends TaxManagerModuleCore {};
class TaxRule extends TaxRuleCore {};
class TaxCalculator extends TaxCalculatorCore {};
class TaxConfiguration extends TaxConfigurationCore {};
class TaxRulesTaxManager extends TaxRulesTaxManagerCore {};
class TaxManagerFactory extends TaxManagerFactoryCore {};
class EmployeeSession extends EmployeeSessionCore {};
class SpecificPriceFormatter extends SpecificPriceFormatterCore {};
class PrestaShopDatabaseException extends PrestaShopDatabaseExceptionCore {};
class PrestaShopModuleException extends PrestaShopModuleExceptionCore {};
class PrestaShopException extends PrestaShopExceptionCore {};
class PrestaShopPaymentException extends PrestaShopPaymentExceptionCore {};
class PrestaShopObjectNotFoundException extends PrestaShopObjectNotFoundExceptionCore {};
class Curve extends CurveCore {};
class Category extends CategoryCore {};
class ConnectionsSource extends ConnectionsSourceCore {};
class Referrer extends ReferrerCore {};
class CartRule extends CartRuleCore {};
class Attribute extends AttributeCore {};
class CustomerMessage extends CustomerMessageCore {};
class Tab extends TabCore {};
class TreeToolbar extends TreeToolbarCore {};
abstract class TreeToolbarButton extends TreeToolbarButtonCore {};
class TreeToolbarSearchCategories extends TreeToolbarSearchCategoriesCore {};
class Tree extends TreeCore {};
class TreeToolbarSearch extends TreeToolbarSearchCore {};
class TreeToolbarLink extends TreeToolbarLinkCore {};
class Page extends PageCore {};
class Guest extends GuestCore {};
class CustomerSession extends CustomerSessionCore {};
class Dispatcher extends DispatcherCore {};
class WebserviceSpecificManagementAttachments extends WebserviceSpecificManagementAttachmentsCore {};
class WebserviceSpecificManagementSearch extends WebserviceSpecificManagementSearchCore {};
class WebserviceSpecificManagementImages extends WebserviceSpecificManagementImagesCore {};
class WebserviceOutputXML extends WebserviceOutputXMLCore {};
class WebserviceOutputBuilder extends WebserviceOutputBuilderCore {};
class WebserviceException extends WebserviceExceptionCore {};
class WebserviceOutputJSON extends WebserviceOutputJSONCore {};
class WebserviceKey extends WebserviceKeyCore {};
class WebserviceRequest extends WebserviceRequestCore {};
class CacheXcache extends CacheXcacheCore {};
abstract class Cache extends CacheCore {};
class CacheMemcache extends CacheMemcacheCore {};
class CacheApc extends CacheApcCore {};
class CacheMemcached extends CacheMemcachedCore {};
class QuickAccess extends QuickAccessCore {};
class CMSRole extends CMSRoleCore {};
class State extends StateCore {};
class Pack extends PackCore {};
class PhpEncryptionEngine extends PhpEncryptionEngineCore {};
class ProductSale extends ProductSaleCore {};
class CustomerFormatter extends CustomerFormatterCore {};
class CustomerAddressPersister extends CustomerAddressPersisterCore {};
class CustomerLoginForm extends CustomerLoginFormCore {};
class FormField extends FormFieldCore {};
abstract class AbstractForm extends AbstractFormCore {};
class CustomerLoginFormatter extends CustomerLoginFormatterCore {};
class CustomerPersister extends CustomerPersisterCore {};
class CustomerAddressFormatter extends CustomerAddressFormatterCore {};
class CustomerAddressForm extends CustomerAddressFormCore {};
class CustomerForm extends CustomerFormCore {};
class QqUploadedFileForm extends QqUploadedFileFormCore {};
class SearchEngine extends SearchEngineCore {};
class Connection extends ConnectionCore {};
class Message extends MessageCore {};
class CMS extends CMSCore {};
class PhpEncryptionLegacyEngine extends PhpEncryptionLegacyEngineCore {};
class Delivery extends DeliveryCore {};
class Feature extends FeatureCore {};
class WarehouseAddress extends WarehouseAddressCore {};
class ValidateConstraintTranslator extends ValidateConstraintTranslatorCore {};
class Uploader extends UploaderCore {};
class CSV extends CSVCore {};
class RequestSql extends RequestSqlCore {};
class CustomizationField extends CustomizationFieldCore {};
class TranslatedConfiguration extends TranslatedConfigurationCore {};
class ManufacturerAddress extends ManufacturerAddressCore {};
class Meta extends MetaCore {};
class GroupReduction extends GroupReductionCore {};
class PrestaShopCollection extends PrestaShopCollectionCore {};
class AddressFormat extends AddressFormatCore {};
class Translate extends TranslateCore {};
class Tag extends TagCore {};
class Group extends GroupCore {};
class AttributeGroup extends AttributeGroupCore {};
class Product extends ProductCore {};
class ConfigurationTest extends ConfigurationTestCore {};
class ConfigurationKPI extends ConfigurationKPICore {};
class Chart extends ChartCore {};
class PhpEncryption extends PhpEncryptionCore {};
class Mail extends MailCore {};
class SpecificPrice extends SpecificPriceCore {};
class Notification extends NotificationCore {};
class Hook extends HookCore {};
class Address extends AddressCore {};
class DateRange extends DateRangeCore {};
class QqUploadedFileXhr extends QqUploadedFileXhrCore {};
class ProductSupplier extends ProductSupplierCore {};
class ShopGroup extends ShopGroupCore {};
class Shop extends ShopCore {};
class ShopUrl extends ShopUrlCore {};
class RangePrice extends RangePriceCore {};
class RangeWeight extends RangeWeightCore {};
class FeatureValue extends FeatureValueCore {};
class SmartyResourceModule extends SmartyResourceModuleCore {};
class TemplateFinder extends TemplateFinderCore {};
class SmartyResourceParent extends SmartyResourceParentCore {};
class SmartyCustom extends SmartyCustomCore {};
class SmartyCustomTemplate extends SmartyCustomTemplateCore {};
class SmartyDevTemplate extends SmartyDevTemplateCore {};
class Validate extends ValidateCore {};
class LinkProxy extends LinkProxyCore {};
class HelperForm extends HelperFormCore {};
class HelperImageUploader extends HelperImageUploaderCore {};
class HelperTreeCategories extends HelperTreeCategoriesCore {};
class HelperOptions extends HelperOptionsCore {};
class HelperKpiRow extends HelperKpiRowCore {};
class HelperCalendar extends HelperCalendarCore {};
class HelperKpi extends HelperKpiCore {};
class HelperList extends HelperListCore {};
class HelperTreeShops extends HelperTreeShopsCore {};
class HelperShop extends HelperShopCore {};
class Helper extends HelperCore {};
class HelperUploader extends HelperUploaderCore {};
class HelperView extends HelperViewCore {};
class Customization extends CustomizationCore {};
class ProductPresenterFactory extends ProductPresenterFactoryCore {};
