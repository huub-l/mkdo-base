// Images, svgs and fonts.
function requireAll(r) {
	r.keys().forEach(r);
}
requireAll(require.context('../images/', true, /\.(png|jpg|gif)$/));
requireAll(require.context('../svgs/', true, /\.(svg)$/));
requireAll(require.context('../fonts/', true, /\.(woff(2)?|ttf|eot)$/));

// JS
import userAgentClasses from './modules/user-agent-classes.js';

// Run
userAgentClasses();
