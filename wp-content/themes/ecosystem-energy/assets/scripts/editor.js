wp.domReady(() => {
  /*
    Change Gutenbergs Buttons block
    Unregister Default Block
    Create new Block 
  */
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
  wp.blocks.registerBlockStyle('core/button', [
    {
      name: 'large',
      label: 'Large',
      isDefault: false,
    },
    {
      name: 'small',
      label: 'Petit',
      isDefault: false,
    },
    {
      name: 'secondary',
      label: 'Secondaire',
      isDefault: false,
    },
  ]);

  /*
    Change Gutenbergs Separtor block
    Unregister Default Block
  */
  wp.blocks.unregisterBlockStyle('core/separator', 'dots');
  wp.blocks.unregisterBlockStyle('core/separator', 'wide');

  /*
    Change Gutenbergs BlockQuot block
    Register New Style
  */
  wp.blocks.registerBlockStyle('core/quote', [
    {
      name: 'large',
      label: 'Large',
      isDefault: true,
    },
    {
      name: 'classic',
      label: 'Classique',
      isDefault: false,
    }
  ]);

  /*
    Change Gutenbergs Paragraph block
    Register New Style
  */
  wp.blocks.registerBlockStyle('core/paragraph', [
    {
      name: 'framed',
      label: 'Encadrée',
      isDefault: false,
    }
  ]);

  /*
    Change Gutenbergs Paragraph block
    Register New Style
  */
  wp.blocks.registerBlockStyle('core/columns', [
    {
      name: 'framed',
      label: 'Encadrée',
      isDefault: false,
    }
  ]);

  /*
    Change Gutenbergs List block
    Register New Style
  */
  wp.blocks.registerBlockStyle('core/list', [
    {
      name: 'bigger',
      label: 'Mise en avant',
      isDefault: false,
    }
  ]);

  /*
    Change Gutenbergs Table block
    Unregister Default Block
  */
  wp.blocks.unregisterBlockStyle('core/table', 'stripes');

});