import { mount } from '@vitest/vite-plugin-vue2'
import MyComponent from '../resources/js/components/MyComponent.vue'

test('MyComponent renders correctly', async () => {
  const wrapper = await mount(MyComponent)
  expect(wrapper.html()).toMatchSnapshot()
})
