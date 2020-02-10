<template>
  <div class="editor">
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <div class="menubar text-center">

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.bold() }"
          @click.prevent="commands.bold"
        >
          <icon name="bold" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.italic() }"
          @click.prevent="commands.italic"
        >
          <icon name="italic" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.strike() }"
          @click.prevent="commands.strike"
        >
          <icon name="strike" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.underline() }"
          @click.prevent="commands.underline"
        >
          <icon name="underline" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.code() }"
          @click.prevent="commands.code"
        >
          <icon name="code" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.paragraph() }"
          @click.prevent="commands.paragraph"
        >
          <icon name="paragraph" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.heading({ level: 1 }) }"
          @click.prevent="commands.heading({ level: 1 })"
        >
          H1
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.heading({ level: 2 }) }"
          @click.prevent="commands.heading({ level: 2 })"
        >
          H2
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.heading({ level: 3 }) }"
          @click.prevent="commands.heading({ level: 3 })"
        >
          H3
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.bullet_list() }"
          @click.prevent="commands.bullet_list"
        >
          <icon name="ul" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.ordered_list() }"
          @click.prevent="commands.ordered_list"
        >
          <icon name="ol" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.blockquote() }"
          @click.prevent="commands.blockquote"
        >
          <icon name="quote" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.code_block() }"
          @click.prevent="commands.code_block"
        >
          <icon name="code" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          @click.prevent="commands.horizontal_rule"
        >
          <icon name="hr" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          @click.prevent="commands.undo"
        >
          <icon name="undo" />
        </button>

        <button
          class="menubar__button btn btn-sm btn-light"
          @click.prevent="commands.redo"
        >
          <icon name="redo" />
        </button>

      </div>
    </editor-menu-bar>

    <editor-menu-bubble :editor="editor" :keep-in-bounds="keepInBounds" v-slot="{ commands, isActive, menu }">
      <div
        class="menububble"
        :class="{ 'is-active': menu.isActive }"
        :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
      >

        <button
          class="menububble__button"
          :class="{ 'is-active': isActive.bold() }"
          @click.prevent="commands.bold"
        >
          <icon name="bold" />
        </button>

        <button
          class="menububble__button"
          :class="{ 'is-active': isActive.italic() }"
          @click.prevent="commands.italic"
        >
          <icon name="italic" />
        </button>

        <button
          class="menububble__button"
          :class="{ 'is-active': isActive.code() }"
          @click.prevent="commands.underline"
        >
          <icon name="underline" />
        </button>

      </div>
    </editor-menu-bubble>

    <editor-content class="editor__content" :editor="editor" />
  </div>
</template>

<script>
import Icon from '../Shared/Icon'
import {
  Editor,
  EditorContent,
  EditorMenuBar,
  EditorMenuBubble
} from 'tiptap'

import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  HorizontalRule,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from 'tiptap-extensions'

export default {
  name: 'Editor',
  props: {
    value: [String],
    format: {
      type: String,
      default: 'html',
      validator: function (value) {
        // The value must match one of these strings
        return ['html', 'json'].indexOf(value) !== -1
      }
    }
  },
  components: {
    EditorContent,
    EditorMenuBar,
    EditorMenuBubble,
    Icon,
  },
  data() {
    return {
      keepInBounds: true,
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new BulletList(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new HorizontalRule(),
          new ListItem(),
          new OrderedList(),
          new TodoItem(),
          new TodoList(),
          new Link(),
          new Bold(),
          new Code(),
          new Italic(),
          new Strike(),
          new Underline(),
          new History(),
        ],
        content: this.value,
        onUpdate: ({ getJSON, getHTML }) => {
          let output = null

          if (this.format === 'json') {
            output = getJSON()
          } else {
            output = getHTML()
          }

          this.$emit('input', output)
        },
      }),
    }
  },
  beforeDestroy() {
    this.editor.destroy()
  },
}
</script>
