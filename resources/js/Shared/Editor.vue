<template>
  <div class="editor">
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <div :class="['menubar text-center', { 'is-hidden': hidden }]">

        <button
          v-b-tooltip.hover
          title="Bold"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.bold() }"
          @click.prevent="commands.bold"
        >
          <icon name="bold" />
        </button>

        <button
          v-b-tooltip.hover
          title="Italic"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.italic() }"
          @click.prevent="commands.italic"
        >
          <icon name="italic" />
        </button>

        <button
          v-b-tooltip.hover
          title="Strike"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.strike() }"
          @click.prevent="commands.strike"
        >
          <icon name="strike" />
        </button>

        <button
          v-b-tooltip.hover
          title="Underline"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.underline() }"
          @click.prevent="commands.underline"
        >
          <icon name="underline" />
        </button>

        <button
          v-b-tooltip.hover
          title="Code"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.code() }"
          @click.prevent="commands.code"
        >
          <icon name="code" />
        </button>

        <button
          v-b-tooltip.hover
          title="Paragraph"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.paragraph() }"
          @click.prevent="commands.paragraph"
        >
          <icon name="paragraph" />
        </button>

        <button
          v-b-tooltip.hover
          title="Heading"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.heading({ level: 1 }) }"
          @click.prevent="commands.heading({ level: 1 })"
        >
          H1
        </button>

        <button
          v-b-tooltip.hover
          title="Title"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.heading({ level: 2 }) }"
          @click.prevent="commands.heading({ level: 2 })"
        >
          H2
        </button>

        <button
          v-b-tooltip.hover
          title="Sub title"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.heading({ level: 3 }) }"
          @click.prevent="commands.heading({ level: 3 })"
        >
          H3
        </button>

        <button
          v-b-tooltip.hover
          title="Bullet list"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.bullet_list() }"
          @click.prevent="commands.bullet_list"
        >
          <icon name="ul" />
        </button>

        <button
          v-b-tooltip.hover
          title="Ordered list"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.ordered_list() }"
          @click.prevent="commands.ordered_list"
        >
          <icon name="ol" />
        </button>

        <button
          v-b-tooltip.hover
          title="Blockquote"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.blockquote() }"
          @click.prevent="commands.blockquote"
        >
          <icon name="quote" />
        </button>

        <button
          v-b-tooltip.hover
          title="Code block"
          class="menubar__button btn btn-sm btn-light"
          :class="{ 'active': isActive.code_block() }"
          @click.prevent="commands.code_block"
        >
          <icon name="code" />
        </button>

        <button
          v-b-tooltip.hover
          title="Line break"
          class="menubar__button btn btn-sm btn-light"
          @click.prevent="commands.horizontal_rule"
        >
          <icon name="hr" />
        </button>

        <button
          v-b-tooltip.hover
          title="Undo"
          class="menubar__button btn btn-sm btn-light"
          @click.prevent="commands.undo"
        >
          <icon name="undo" />
        </button>

        <button
          v-b-tooltip.hover
          title="Redo"
          class="menubar__button btn btn-sm btn-light"
          @click.prevent="commands.redo"
        >
          <icon name="redo" />
        </button>

        <!-- <button
          v-b-popover.hover.top="'Styling with Markdown is supported'"
          title="Help"
          class="menubar__button btn btn-sm btn-light ml-2"
        >
          <i class="fe fe-help-circle"></i>
        </button> -->
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
  Placeholder
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
    },
    placeholder: {
      type: String,
      default: 'Write something …'
    },
    hidden: {
      type: Boolean,
      default: false
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
          new Placeholder({
            emptyNodeText: this.placeholder
          }),
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

<style lang="scss">
.editor p.is-editor-empty:first-child::before {
  content: attr(data-empty-text);
  float: left;
  color: #aaa;
  pointer-events: none;
  height: 0;
  font-style: italic;
}
</style>
