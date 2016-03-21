<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
$this->setGlobalTtaInfo();

$this->enqueueTtaScript();

// It is required to be before tabs-list-top/left/bottom/right for tabs/tours
$prepareContent = $this->getTemplateVariable( 'content' );

$output = '<div ' . $this->getWrapperAttributes() . '>';
$output .= $this->getTemplateVariable( 'title' );
$output .= '<div class="' . esc_attr( $this->getTtaGeneralClasses() ) . '">';
if($this->getShortcode()=="vc_tta_tabs" && $atts['type']=="vertical") {
    $vertical_output = str_replace("vc_tta-tabs-container", "vc_tta-tabs-container col-sm-3 vertical",$this->getTemplateVariable( 'tabs-list-top' )); 
    $output .= $vertical_output;
} else {
    $output .= $this->getTemplateVariable( 'tabs-list-top' );
}
$output .= $this->getTemplateVariable( 'tabs-list-left' );
if($this->getShortcode()=="vc_tta_tabs" && $atts['type']=="vertical") {
    $output .= '<div class="vc_tta-panels-container col-sm-9">';
} else {
    $output .= '<div class="vc_tta-panels-container">';
}
$output .= $this->getTemplateVariable( 'pagination-top' );
$output .= '<div class="vc_tta-panels">';
$output .= $prepareContent;
$output .= '</div>';
$output .= $this->getTemplateVariable( 'pagination-bottom' );
$output .= '</div>';
if($this->getShortcode()=="vc_tta_tabs" && $atts['type']=="vertical") {
    $vertical_output = str_replace("vc_tta-tabs-container", "vc_tta-tabs-container col-sm-3 vertical",$this->getTemplateVariable( 'tabs-list-bottom' )); 
    $output .= $vertical_output;
} else {
    $output .= $this->getTemplateVariable( 'tabs-list-bottom' );
}
$output .= $this->getTemplateVariable( 'tabs-list-right' );
$output .= '</div>';
$output .= '</div>';

echo $output;