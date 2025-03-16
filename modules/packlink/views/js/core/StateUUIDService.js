/**
 * 2025 Packlink
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License 2.0
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @author    Packlink <support@packlink.com>
 * @copyright 2025 Packlink Shipping S.L
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt  Apache License 2.0
 */
if (!window.Packlink) {
    window.Packlink = {};
}

(() => {
    function StateUUIDService() {
        let currentState = '';

        this.setStateUUID = (state) => {
            currentState = state;
        };

        this.getStateUUID = () => {
            return currentState;
        };
    }

    Packlink.StateUUIDService = new StateUUIDService();
})();
