<?php
namespace BenKruzMenu\Includes;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Ben_Kruz_Header_Widget extends Widget_Base {

    public function get_name() {
        return 'ben_kruz_header';
    }

    public function get_title() {
        return esc_html__( 'Ben Kruz Menu Pro v4', 'ben-kruz-menu' );
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_script_depends() {
        return [ 'bkm-script' ];
    }

    public function get_style_depends() {
        return [ 'bkm-style' ];
    }

    protected function register_controls() {

        /* --- İÇERİK SEKMESİ --- */

        // Logo
        $this->start_controls_section(
            'section_logo_content',
            [ 'label' => esc_html__( 'Logo', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_CONTENT ]
        );
        $this->add_control(
            'logo',
            [
                'label' => esc_html__( 'Logo Görseli', 'ben-kruz-menu' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
            ]
        );
        $this->add_control(
            'logo_link',
            [
                'label' => esc_html__( 'Logo Linki', 'ben-kruz-menu' ),
                'type' => Controls_Manager::URL,
                'default' => [ 'url' => '/' ],
            ]
        );
        $this->end_controls_section();

        // Menü Elemanları
        $this->start_controls_section(
            'section_menu_content',
            [ 'label' => esc_html__( 'Menü Elemanları', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_CONTENT ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'text', [ 'label' => 'Başlık', 'type' => Controls_Manager::TEXT, 'default' => 'Menu Item' ] );
        $repeater->add_control( 'link', [ 'label' => 'Link', 'type' => Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
        $repeater->add_control( 'badge', [ 'label' => 'Badge Yazısı', 'type' => Controls_Manager::TEXT, 'default' => '' ] );
        
        $this->add_control(
            'menu_items',
            [
                'label' => 'Menü Listesi',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'text' => 'Ana Sayfa', 'link' => ['url' => '/'] ],
                    [ 'text' => 'LGS', 'badge' => 'YENİ', 'link' => ['url' => '#'] ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );
        $this->end_controls_section();

        // Butonlar
        $this->start_controls_section(
            'section_buttons_content',
            [ 'label' => esc_html__( 'Butonlar (CTA)', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_CONTENT ]
        );
        $cta_repeater = new \Elementor\Repeater();
        $cta_repeater->add_control( 'text', [ 'label' => 'Sekme Metni', 'type' => Controls_Manager::TEXT, 'default' => 'Yeni Sekme' ] );
        $cta_repeater->add_control( 'link', [ 'label' => 'Sekme Linki', 'type' => Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
        $cta_repeater->add_control(
            'style',
            [
                'label' => 'Sekme Stili',
                'type' => Controls_Manager::SELECT,
                'default' => 'outline',
                'options' => [
                    'outline' => 'Outline',
                    'primary' => 'Solid',
                ],
            ]
        );
        $this->add_control(
            'cta_items',
            [
                'label' => 'Sekmeler',
                'type' => Controls_Manager::REPEATER,
                'fields' => $cta_repeater->get_controls(),
                'default' => [
                    [ 'text' => 'Giriş Yap', 'link' => [ 'url' => '#' ], 'style' => 'outline' ],
                    [ 'text' => 'Kayıt Ol', 'link' => [ 'url' => '#' ], 'style' => 'primary' ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );
        $this->end_controls_section();

        // Mobil İkonlar
        $this->start_controls_section(
            'section_mobile_icons',
            [ 'label' => esc_html__( 'Mobil İkonlar', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_CONTENT ]
        );
        $this->add_control(
            'icon_open',
            [
                'label' => esc_html__( 'Menü Açma İkonu', 'ben-kruz-menu' ),
                'type' => Controls_Manager::ICONS,
                'default' => [ 'value' => 'fas fa-bars', 'library' => 'fa-solid' ],
            ]
        );
        $this->add_control(
            'icon_close',
            [
                'label' => esc_html__( 'Menü Kapatma İkonu', 'ben-kruz-menu' ),
                'type' => Controls_Manager::ICONS,
                'default' => [ 'value' => 'fas fa-times', 'library' => 'fa-solid' ],
            ]
        );
        $this->end_controls_section();


        /* --- STİL SEKMESİ --- */

        // Konteyner Ayarları
        $this->start_controls_section(
            'section_style_container',
            [ 'label' => esc_html__( 'Konteyner & Arkaplan', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );
        
        $this->add_responsive_control(
            'container_max_width',
            [
                'label' => esc_html__( 'İçerik Genişliği', 'ben-kruz-menu' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px', 'vw' ],
                'range' => [ 
                    '%' => [ 'min' => 0, 'max' => 100 ],
                    'px' => [ 'min' => 0, 'max' => 1920 ] 
                ],
                'selectors' => [ '{{WRAPPER}} .ben-kruz-container' => 'max-width: {{SIZE}}{{UNIT}}; width: 100%;' ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
            ]
        );

        $this->add_control(
            'container_bg_color',
            [
                'label' => esc_html__( 'Arkaplan Rengi', 'ben-kruz-menu' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .ben-kruz-header' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__( 'Header Padding', 'ben-kruz-menu' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .ben-kruz-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .ben-kruz-header',
            ]
        );
        $this->end_controls_section();

        // Logo Stili
        $this->start_controls_section(
            'section_style_logo',
            [ 'label' => esc_html__( 'Logo', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );
        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__( 'Genişlik', 'ben-kruz-menu' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [ 'px' => [ 'min' => 0, 'max' => 500 ] ],
                'selectors' => [ '{{WRAPPER}} .ben-kruz-logo img' => 'width: {{SIZE}}{{UNIT}}; max-height: unset;' ],
            ]
        );
        $this->add_responsive_control(
            'logo_height',
            [
                'label' => esc_html__( 'Yükseklik (Max)', 'ben-kruz-menu' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .ben-kruz-logo img' => 'max-height: {{SIZE}}{{UNIT}};' ],
            ]
        );
        $this->end_controls_section();

        // Menü Stili
        $this->start_controls_section(
            'section_style_menu',
            [ 'label' => esc_html__( 'Menü (Masaüstü)', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} .ben-kruz-nav-desktop a',
            ]
        );
        $this->start_controls_tabs( 'tabs_menu_style' );
        $this->start_controls_tab( 'tab_menu_normal', [ 'label' => 'Normal' ] );
        $this->add_control( 'menu_color', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ben-kruz-nav-desktop a' => 'color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_menu_hover', [ 'label' => 'Hover' ] );
        $this->add_control( 'menu_color_hover', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ben-kruz-nav-desktop a:hover' => 'color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'menu_spacing',
            [
                'label' => 'Öğeler Arası Boşluk',
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .ben-kruz-nav-desktop ul' => 'gap: {{SIZE}}{{UNIT}};' ],
            ]
        );
        $this->end_controls_section();

        // Badge Stili
        $this->start_controls_section(
            'section_style_badge',
            [ 'label' => esc_html__( 'Badge (Etiket)', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'badge_typography', 'selector' => '{{WRAPPER}} .ben-kruz-badge' ] );
        $this->add_control( 'badge_color', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ben-kruz-badge' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Background::get_type(), [ 'name' => 'badge_background', 'label' => 'Arkaplan', 'types' => [ 'classic', 'gradient' ], 'selector' => '{{WRAPPER}} .ben-kruz-badge' ] );
        $this->add_responsive_control( 'badge_padding', [ 'label' => 'Padding', 'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .ben-kruz-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
        $this->add_control( 'badge_radius', [ 'label' => 'Köşe Yuvarlatma', 'type' => Controls_Manager::SLIDER, 'selectors' => [ '{{WRAPPER}} .ben-kruz-badge' => 'border-radius: {{SIZE}}px;' ] ] );
        $this->add_responsive_control( 'badge_gap_mobile', [ 'label' => 'Başlık ile Boşluk', 'type' => Controls_Manager::SLIDER, 'selectors' => [ '{{WRAPPER}} .ben-kruz-nav-desktop a' => 'gap: {{SIZE}}px;', '{{WRAPPER}} .mobile-links a' => 'gap: {{SIZE}}px;' ], 'default' => [ 'size' => 6 ] ] );
        $this->end_controls_section();

        // Buton Stili
        $this->start_controls_section(
            'section_style_buttons',
            [ 'label' => esc_html__( 'Butonlar', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'btn_typography', 'selector' => '{{WRAPPER}} .bkm-btn' ] );
        $this->add_responsive_control( 'buttons_border_radius', [ 'label' => 'Köşe Yuvarlatma', 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .bkm-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
        
        $this->add_control( 'heading_btn1', [ 'label' => 'Buton 1 (Outline)', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->start_controls_tabs( 'tabs_btn1' );
        $this->start_controls_tab( 'tab_btn1_normal', [ 'label' => 'Normal' ] );
        $this->add_control( 'btn1_color', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-outline' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'btn1_bg_color', [ 'label' => 'Arkaplan', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-outline' => 'background-color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'btn1_border', 'selector' => '{{WRAPPER}} .bkm-btn-outline' ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_btn1_hover', [ 'label' => 'Hover' ] );
        $this->add_control( 'btn1_color_hover', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-outline:hover' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'btn1_bg_color_hover', [ 'label' => 'Arkaplan', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-outline:hover' => 'background-color: {{VALUE}};' ] ] );
        $this->add_control( 'btn1_border_hover', [ 'label' => 'Border Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-outline:hover' => 'border-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'heading_btn2', [ 'label' => 'Buton 2 (Solid)', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->start_controls_tabs( 'tabs_btn2' );
        $this->start_controls_tab( 'tab_btn2_normal', [ 'label' => 'Normal' ] );
        $this->add_control( 'btn2_color', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-primary' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'btn2_bg_color', [ 'label' => 'Arkaplan', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-primary' => 'background-color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'btn2_border', 'selector' => '{{WRAPPER}} .bkm-btn-primary' ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_btn2_hover', [ 'label' => 'Hover' ] );
        $this->add_control( 'btn2_color_hover', [ 'label' => 'Yazı Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-primary:hover' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'btn2_bg_color_hover', [ 'label' => 'Arkaplan', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-primary:hover' => 'background-color: {{VALUE}};' ] ] );
        $this->add_control( 'btn2_border_hover', [ 'label' => 'Border Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bkm-btn-primary:hover' => 'border-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control( 'buttons_gap', [ 'label' => 'Butonlar Arası Boşluk', 'type' => Controls_Manager::SLIDER, 'selectors' => [ '{{WRAPPER}} .ben-kruz-cta-desktop' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
        $this->end_controls_section();

        // Mobil Menü Stili
        $this->start_controls_section(
            'section_style_mobile',
            [ 'label' => esc_html__( 'Mobil Menü', 'ben-kruz-menu' ), 'tab' => Controls_Manager::TAB_STYLE ]
        );
        $this->add_control( 'hamburger_icon_color', [ 'label' => 'Hamburger İkon Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ben-kruz-mobile-toggle i, {{WRAPPER}} .ben-kruz-mobile-toggle svg' => 'color: {{VALUE}}; fill: {{VALUE}};' ] ] );
        $this->add_control( 'hamburger_icon_size', [ 'label' => 'İkon Boyutu', 'type' => Controls_Manager::SLIDER, 'selectors' => [ '{{WRAPPER}} .ben-kruz-mobile-toggle' => 'font-size: {{SIZE}}px;' ] ] );
        $this->add_responsive_control( 'mobile_drawer_bg', [ 'label' => 'Açılır Menü Arkaplanı', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ben-kruz-mobile-menu' => 'background-color: {{VALUE}};' ] ] );
        
        // YENİ EKLENEN KONTROL: İç Boşluk (Padding)
        $this->add_responsive_control( 
            'mobile_drawer_padding', 
            [ 
                'label' => 'İç Boşluk (Padding)', 
                'type' => Controls_Manager::DIMENSIONS, 
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .mobile-menu-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
                'default' => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px' ]
            ] 
        );

        $this->add_responsive_control( 'mobile_link_color', [ 'label' => 'Mobil Link Rengi', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .mobile-links a' => 'color: {{VALUE}};' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $logo_url = !empty($settings['logo']['url']) ? $settings['logo']['url'] : '';
        $logo_link = !empty($settings['logo_link']['url']) ? $settings['logo_link']['url'] : '/';
        ?>
        
        <header class="ben-kruz-header">
            <div class="ben-kruz-container">
                <div class="ben-kruz-logo">
                    <a href="<?php echo esc_url($logo_link); ?>"><img src="<?php echo esc_url($logo_url); ?>" alt="Logo"></a>
                </div>
                <nav class="ben-kruz-nav-desktop">
                    <ul>
                        <?php foreach ( $settings['menu_items'] as $item ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $item['link']['url'] ); ?>">
                                    <?php echo esc_html( $item['text'] ); ?>
                                    <?php if ( ! empty( $item['badge'] ) ) : ?><span class="ben-kruz-badge"><?php echo esc_html( $item['badge'] ); ?></span><?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <div class="ben-kruz-cta-desktop">
                    <?php foreach ( $settings['cta_items'] as $cta_item ) : ?>
                        <?php if ( ! empty( $cta_item['text'] ) ) : ?>
                            <?php $cta_style_class = ( isset( $cta_item['style'] ) && 'primary' === $cta_item['style'] ) ? 'bkm-btn-primary' : 'bkm-btn-outline'; ?>
                            <a href="<?php echo esc_url( $cta_item['link']['url'] ); ?>" class="bkm-btn <?php echo esc_attr( $cta_style_class ); ?>"><?php echo esc_html( $cta_item['text'] ); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="ben-kruz-mobile-toggle">
                    <div class="bkm-icon-open"><?php Icons_Manager::render_icon( $settings['icon_open'], [ 'aria-hidden' => 'true' ] ); ?></div>
                    <div class="bkm-icon-close" style="display:none;"><?php Icons_Manager::render_icon( $settings['icon_close'], [ 'aria-hidden' => 'true' ] ); ?></div>
                </div>
            </div>
            <div class="ben-kruz-mobile-menu">
                <div class="mobile-menu-inner">
                    <ul class="mobile-links">
                        <?php foreach ( $settings['menu_items'] as $item ) : ?>
                            <li>
                                <a href="<?php echo esc_url( $item['link']['url'] ); ?>">
                                    <span class="link-text"><?php echo esc_html( $item['text'] ); ?></span>
                                    <?php if ( ! empty( $item['badge'] ) ) : ?><span class="ben-kruz-badge"><?php echo esc_html( $item['badge'] ); ?></span><?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mobile-cta-buttons">
                        <?php foreach ( $settings['cta_items'] as $cta_item ) : ?>
                            <?php if ( ! empty( $cta_item['text'] ) ) : ?>
                                <?php $cta_style_class = ( isset( $cta_item['style'] ) && 'primary' === $cta_item['style'] ) ? 'bkm-btn-primary' : 'bkm-btn-outline'; ?>
                                <a href="<?php echo esc_url( $cta_item['link']['url'] ); ?>" class="bkm-btn <?php echo esc_attr( $cta_style_class ); ?> full-width"><?php echo esc_html( $cta_item['text'] ); ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }
}
