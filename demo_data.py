'''
Generate test data for the blog db
'''

import random

head = """
TRUNCATE TABLE posts;
INSERT INTO Posts (title, slug, publishedAt, smallDesc, content, postImage, authorName, categoryName, published) VALUES
"""
tpl = """
    ('Just a post no. [N]',
    '[N]-blog-post',
    '2020-06-20',
    '[DESC]',
    '[TEXT]',
    '[IMG]',
    'Dominik Kardas',
    '[CATEGORY]',
    1)
"""

lorem = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit.Integer tempor.Nam quis nulla. Maecenas sollicitudin. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vestibulum fermentum tortor id mi. Nam sed tellus id magna elementum tincidunt. Morbi scelerisque luctus velit. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Nullam sit amet magna in magna gravida vehicula. Nunc auctor. Etiam bibendum elit eget erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Aenean fermentum risus id tortor. Pellentesque arcu. Nulla non arcu lacinia neque faucibus fringilla. Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Duis risus. Vestibulum fermentum tortor id mi.Etiam ligula pede, sagittis quis, interdum ultricies, scelerisque eu. Nullam sapien sem, ornare ac, nonummy non, lobortis a enim. Maecenas aliquet accumsan leo. Curabitur sagittis hendrerit ante. Phasellus faucibus molestie nisl. Phasellus rhoncus. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Phasellus rhoncus. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede. Curabitur vitae diam non enim vestibulum interdum. Donec quis nibh at felis congue commodo. Curabitur ligula sapien, pulvinar a vestibulum quis, facilisis vel sapien. Nullam feugiat, turpis at pulvinar vulputate, erat libero tristique tellus, nec bibendum odio risus sit amet ante. In dapibus augue non sapien. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Fusce aliquam vestibulum ipsum. Sed convallis magna eu sem. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. Aliquam erat volutpat. Suspendisse sagittis ultrices augue."
data = []

images = ["images/img1.jpg",
          "images/img2.jpg",
          "images/img3.jpg",
          "images/img4.jpg",
          "images/img5.jpg"]

DATA_COUNT = 25

for i in range(1, DATA_COUNT + 1):
    t = tpl.replace('[N]', str(i))
    t = t.replace('[DESC]', str(lorem[0:random.randrange(0, int(len(lorem) / 4))]))
    t = t.replace('[TEXT]', str(lorem[0:random.randrange(40, len(lorem))]))
    t = t.replace('[POST_NUMBER]', str(i))
    t = t.replace('[IMG]', images[random.randrange(0,len(images))])
    t = t.replace('[CATEGORY]', 'category%s' % str(random.randrange(1, 4)))

    if not (i == DATA_COUNT):
        t += ','

    data.append(t)

with open('demo.txt', 'w') as f:
    
    f.write(head)

    for d in data:
        f.write(d)
