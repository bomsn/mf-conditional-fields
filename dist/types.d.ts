declare module 'mf-conditional-fields' {
    interface MfConditionalFieldsOptions {
        rules?: string | object;
        dynamic?: boolean;
        unsetHidden?: boolean;
        disableHidden?: boolean;
        debug?: boolean;
        depth?: number;
    }

    function mfConditionalFields(
        elements: string | HTMLElement | HTMLElement[] | NodeList,
        options?: MfConditionalFieldsOptions
    ): void;

    export = mfConditionalFields;
}