/**
 * Build styles
 */
import './button.css';

/**
 * @class Button
 * @classdesc Button Tool for Editor.js
 * @property {ButtonData} data - Tool`s input and output data
 * @propert {object} api - Editor.js API instance
 *
 * @typedef {object} ButtonData
 * @description Button Tool`s input and output data
 * @property {string} text - button`s text
 * @property {string} url - button`s url
 *
 * @typedef {object} ButtonConfig
 * @description Button Tool`s initial configuration
 * @property {string} buttonPlaceholder - placeholder to show in button`s text input
 * @property {string} urlPlaceholder - placeholder to show in button`s url input
 */
class Button {
    /**
     * Notify core that read-only mode is supported
     *
     * @returns {boolean}
     */
    static get isReadOnlySupported() {
        return true;
    }

    /**
     * Get Tool toolbox settings
     * icon - Tool icon's SVG
     * title - title to show in toolbox
     *
     * @returns {{icon: string, title: string}}
     */
    static get toolbox() {
        return {
            icon: '<svg width="15" height="14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M358.182 179.361c-19.493-24.768-52.679-31.945-79.872-19.098-15.127-15.687-36.182-22.487-56.595-19.629V67c0-36.944-29.736-67-66.286-67S89.143 30.056 89.143 67v161.129c-19.909-7.41-43.272-5.094-62.083 8.872-29.355 21.795-35.793 63.333-14.55 93.152l109.699 154.001C134.632 501.59 154.741 512 176 512h178.286c30.802 0 57.574-21.5 64.557-51.797l27.429-118.999A67.873 67.873 0 0 0 448 326v-84c0-46.844-46.625-79.273-89.818-62.639zM80.985 279.697l27.126 38.079c8.995 12.626 29.031 6.287 29.031-9.283V67c0-25.12 36.571-25.16 36.571 0v175c0 8.836 7.163 16 16 16h6.857c8.837 0 16-7.164 16-16v-35c0-25.12 36.571-25.16 36.571 0v35c0 8.836 7.163 16 16 16H272c8.837 0 16-7.164 16-16v-21c0-25.12 36.571-25.16 36.571 0v21c0 8.836 7.163 16 16 16h6.857c8.837 0 16-7.164 16-16 0-25.121 36.571-25.16 36.571 0v84c0 1.488-.169 2.977-.502 4.423l-27.43 119.001c-1.978 8.582-9.29 14.576-17.782 14.576H176c-5.769 0-11.263-2.878-14.697-7.697l-109.712-154c-14.406-20.223 14.994-42.818 29.394-22.606zM176.143 400v-96c0-8.837 6.268-16 14-16h6c7.732 0 14 7.163 14 16v96c0 8.837-6.268 16-14 16h-6c-7.733 0-14-7.163-14-16zm75.428 0v-96c0-8.837 6.268-16 14-16h6c7.732 0 14 7.163 14 16v96c0 8.837-6.268 16-14 16h-6c-7.732 0-14-7.163-14-16zM327 400v-96c0-8.837 6.268-16 14-16h6c7.732 0 14 7.163 14 16v96c0 8.837-6.268 16-14 16h-6c-7.732 0-14-7.163-14-16z"></path></svg>',
            title: 'Button',
        };
    }

    /**
     * Empty Button is not empty Block
     *
     * @public
     * @returns {boolean}
     */
    static get contentless() {
        return true;
    }

    /**
     * Allow to press Enter inside the Button
     *
     * @public
     * @returns {boolean}
     */
    static get enableLineBreaks() {
        return false;
    }

    /**
     * Default placeholder for button text
     *
     * @public
     * @returns {string}
     */
    static get DEFAULT_TEXT_PLACEHOLDER() {
        return 'Click me!';
    }

    /**
     * Default placeholder for button url
     *
     * @public
     * @returns {string}
     */
    static get DEFAULT_URL_PLACEHOLDER() {
        return 'https://mailcoach.app';
    }

    /**
     * Allow Button to be converted to/from other blocks
     */
    static get conversionConfig() {
        return {
            /**
             * To create Button data from string, simple fill 'text' property
             */
            import: 'text',
            /**
             * To create string from Button data, concatenate text and url
             *
             * @param {ButtonData} buttonData
             * @returns {string}
             */
            export: function (buttonData) {
                return buttonData.url ? `${buttonData.text} — ${buttonData.url}` : buttonData.text;
            },
        };
    }

    /**
     * Tool`s styles
     *
     * @returns {{baseClass: string, wrapper: string, button: string, input: string, url: string, text: string}}
     */
    get CSS() {
        return {
            baseClass: this.api.styles.block,
            wrapper: 'cdx-button',
            text: 'cdx-button__text',
            input: this.api.styles.input,
            url: 'cdx-button__url',
        };
    }

    /**
     * Render plugin`s main Element and fill it with saved data
     *
     * @param {{data: ButtonData, config: ButtonConfig, api: object}}
     *   data — previously saved data
     *   config - user config for Tool
     *   api - Editor.js API
     *   readOnly - read-only mode flag
     */
    constructor({ data, config, api, readOnly}) {
        this.api = api;
        this.readOnly = readOnly;

        this.buttonPlaceholder = config.buttonPlaceholder || Button.DEFAULT_TEXT_PLACEHOLDER;
        this.urlPlaceholder = config.urlPlaceholder || Button.DEFAULT_URL_PLACEHOLDER;

        this.data = {
            text: data.text || '',
            url: data.url || '',
        };
    }

    /**
     * Create Button Tool container with inputs
     *
     * @returns {Element}
     */
    render() {
        const container = this._make('div', [this.CSS.baseClass, this.CSS.wrapper], {
            style: 'text-align: left; margin-bottom: 10px;'
        });

        const label = this._make('div', ['mb-2'], {
            innerHTML: 'Button',
            style: 'font-weight: bold;',
        });

        container.appendChild(label);

        const textWrapper = this._make('div', ['flex', 'items-center']);
        const textLabel = this._make('label', ['mr-2', 'w-16'], {
            innerHTML: 'Text:',
        })
        const text = this._make('div', [this.CSS.input, this.CSS.text], {
            contentEditable: !this.readOnly,
            innerHTML: this.data.text,
        });
        textWrapper.appendChild(textLabel);
        textWrapper.appendChild(text);

        const urlWrapper = this._make('div', ['flex', 'items-center']);
        const urlLabel = this._make('label', ['mr-2', 'w-16'], {
            innerHTML: 'Url:',
        })
        const url = this._make('div', [this.CSS.input, this.CSS.url], {
            contentEditable: !this.readOnly,
            innerHTML: this.data.url,
        });
        urlWrapper.appendChild(urlLabel);
        urlWrapper.appendChild(url);

        text.dataset.placeholder = this.buttonPlaceholder;
        url.dataset.placeholder = this.urlPlaceholder;

        container.appendChild(textWrapper);
        container.appendChild(urlWrapper);

        return container;
    }

    /**
     * Extract Button data from Button Tool element
     *
     * @param {HTMLDivElement} buttonElement - element to save
     * @returns {ButtonData}
     */
    save(buttonElement) {
        const text = buttonElement.querySelector(`.${this.CSS.text}`);
        const url = buttonElement.querySelector(`.${this.CSS.url}`);

        return Object.assign(this.data, {
            text: text.innerHTML,
            url: url.innerHTML,
        });
    }

    /**
     * Sanitizer rules
     */
    static get sanitize() {
        return {
            text: {
                br: false,
            },
            url: {
                br: false,
            },
        };
    }

    /**
     * Helper for making Elements with attributes
     *
     * @param  {string} tagName           - new Element tag name
     * @param  {Array|string} classNames  - list or name of CSS classname(s)
     * @param  {object} attributes        - any attributes
     * @returns {Element}
     */
    _make(tagName, classNames = null, attributes = {}) {
        const el = document.createElement(tagName);

        if (Array.isArray(classNames)) {
            el.classList.add(...classNames);
        } else if (classNames) {
            el.classList.add(classNames);
        }

        for (const attrName in attributes) {
            el[attrName] = attributes[attrName];
        }

        return el;
    }
}

export default Button;
